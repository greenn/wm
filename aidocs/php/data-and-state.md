# Data, state, API и storage

## Quick values и property paths

Базовый набор обычно начинается с `_needphp('fq')`. Aggregator загружает
проверки типов, преобразование вывода, arguments/arrays, merge, properties и
selection. Отдельные `fq/arr`, `fq/merge`, `fq/str` helpers автоматически не
гарантированы — их нужно подключать точным именем.

Часто используемые signatures:

```php
prop($stack, $name, $otherwise = null)
has_prop($arr, $prop)
prop_hit($stack, $names, $otherwise = null)
argsArr(/* key, value, ... */)
array_ensure($value, $leftUnchanged = false, $transformOpt = null)
merge(/* $arg1, ..., $argN */)
assignValue($data, $rules, $exist = true)

getValueByPath($data, $path)
isPathExists($data, $path)
setValueByPath(&$array, $path, $value)
pushValueByPath(&$array, $path, $value)

pp($data, $path/*, $value */)
propPath::get($data, $path)
propPath::has($data, $path)
propPath::set(&$data, $path, $value)
propPath::unset(&$data, $path)
```

`dataPath.php` и class `dataPath` — другое, более старое path API с собственным
error state. Не смешивать две семьи в новом consumer-е без необходимости.

## Process globals, request, cookie и session

| Store | API | Side effects / требования |
|---|---|---|
| `$GLOBALS` | `g(...)`, `gHas($name)`, `gDel($name)`, `gIncr($name)`, `gDecr($name)` | изменяет process globals |
| GET/ref | `gt`, `gtv`, `gt_has`, `gt_is`, `gt_on`, `gi*`, `grt*`, `gf*` | читает request/referrer data; family историческая |
| cookie | `ck(...)`, `ckHas`, `ckVal`, `ckDel` | читает/пишет cookies/headers; JSON encode/decode |
| session | `s_init`, `s_close`, `s`, `sHas`, `sDel`, `s_push`, `s_inc`, `s_prop`, `s_set`, `s_setChain` | требует корректного session lifecycle |
| in-memory `x` | `x`, `_x`, `xd`, `x_get`, `x_set`, `x_push`, `x_merge`, `x_flush`, `xc` | static/process store через `xvar` |
| undefined sentinel | `undef`, `isUndef`, `isDef`, class `undefinedValue` | отличает «не задано» от `null`/`false` |

`ck.php` запрашивает `ck` и `json`; self-request `_needphp('ck')` выглядит
историческим и не должен копироваться как pattern. `s.php` подключает cookie,
serialization и `x`; создание session не следует предполагать — проверять
`s_init()`/окружение конкретного consumer-а.

## JSON helpers

```text
_needphp('json')
  -> json/jsonEncode.php
  -> json/jsonFile.php
  -> json/jsonError.php
  -> json/jsonTryDecode.php
```

Public globals:

```php
jsonEncode($data, $prettyJson = false)
jsonPrettyEncode($data)
jsonFile_put_data($path, $data)
jsonFile_get_data($path)
jsonLastErrorMsg()
jsonErrorMsg($errorCode)
jsonTryDecode($data, $asArray = true)
jsonString($data, $prettyJson = false)
outputASJson($data, $headers = true, $filePath = null, $prettyOutput = true)
```

Подтверждённые consumers aggregator-а есть в `r/rb/json/json.class.inc`,
`r/rb/system-/system.inc` и нескольких `kot/.../api/*.inc`. Это подтверждает
рабочее использование family, но не делает file-backed JSON безопасной БД.
Product/catalog JSON нельзя массово читать; при записи проверять locking,
permissions, backup и конкурентный доступ.

### `J`/`JC`

`web/php/j.php` предоставляет facade `j(...)` и классы `J`, `JC` для
file/include-backed data: path resolution, load, slice, save и delete. Он имеет
filesystem side effects и legacy dependencies; одна ссылка на
`json/l/jc.php` не разрешается текущим деревом. Перед новым использованием
проверить реальный path type и consumer, не считать его current JSON ORM.

## Response model

`web/php/response.php` определяет:

```php
response($msgList)
new responseData($conf = array())
```

Ключевые методы `responseData`: `msg`, `info`, `act`, `error`, `res`,
`state`, `res_ok`, `response`. Объект аккумулирует data/errors/actions/info и
возвращает response array. Properties с ведущим `_` фильтруются
`responseData::res_filter()` если явно не разрешены provider-ом.

Call chain:

```text
consumer -> responseData::{res,error,act,info}
         -> responseData::response($provide)
         -> API::makeMultiData(...) for multi messages
         -> caller/endpoint performs final JSON/plain output
```

Сам `responseData` не является HTTP authorization layer.

## API request runner

Top-level signatures:

```php
api_default($ctx = null, $opts = null)
api($method = 'get', $path = '', $data = true,
    $apiInst = true, $apiOpts = null, $apiCtx = null)
```

`api.php` напрямую включает `api/api.class.php`. `api_default()` хранит один
static instance. `api()` выбирает default/provided/new `API`, применяет ctx и
opts, вызывает `API::run()` и возвращает `API::responseData()`.

`API` умеет получать method data, разбирать request/path, искать handler/token,
формировать reply JSON/plain и имеет convenience `get/post/put/patch/delete`.
Это отдельный PHP helper; root API routing по `<route>.<method>.inc` описывается
в routing docs и не должен выводиться только из имени этого класса.

Перед применением проверять:

- кто задаёт API context/config и handler directories;
- server-side authentication/ACL, а не frontend visibility;
- allowed method и input validation;
- отсутствие token/credentials в logs/docs;
- кто фактически вызывает `reply*()` и прекращает execution.

## `crud_json`

`web/php/crud_json.php` определяет `class crud_json extends responseData`.
Public workflow: `set`, `getScheme`, `dataSync`, `create`, `read`, `update`,
`delete`; file helpers обрабатываются через `handleFileData`/
`handleFilesData`.

Фактические declared dependencies:

```text
crud_json
  -> api
  -> response
  -> set
  -> file/file_backup
  -> img/pathImage
  -> data file and optionally session
```

Класс пишет JSON/data files, создаёт backup и может перемещать/обрабатывать
uploads. Он не является универсальной транзакционной storage-системой. Для
новой задачи отдельно проверять path containment, locking, upload MIME/size,
atomicity и authorization.

## Scheme

```php
scheme($schemeData, $opts = false)
new scheme($conf, $initConf = false)
```

Основные методы: `verify($data, $mode)`, `verifyUnique`, `verifyChanges`,
`getIdName`, `setId`. `scheme/ scheme_api.php` добавляет dynamic method facade.
Схема валидирует данные в терминах текущего implementation; не считать её
автоматической защитой SQL, filesystem или HTTP boundaries.

## MySQL и structured data

Нижний слой:

- `_mysql`: connection/config, escaping, SQL helpers и fetch;
- `mysql`: instance facade, query/error/count/all_data;
- `mysql_db`, `mysql_table`, `mysql_item`: DB/table/item operations;
- `mc`: static proxy;
- `mysql/-b/*`: старые procedural helpers, включая `mysql_conf()`;
- `_sd($name, $method = false, ...)` + classes `_sd`, `sd`: schema/table data.

Aggregator `web/php/mysql.php` пытается загрузить `mysql/sd.class.php`, которого
в текущем дереве нет; `sd` находится в отдельном `web/php/sd.php`. Поэтому
`_needphp('mysql')` нельзя объявлять полностью исправной цепочкой без runtime
проверки.

`web/lib/ptf/ptf.php` также вызывает `_needphp('mysql')` и получает DB config
через `mysql_conf()`. Никогда не переносить значения config в aidocs/logs.

## CSV, serialization и text values

```php
read_csv($path, $delimiter = ';', $encode = false)
create_csv($path, $data, $delimiter = ';')
output_csv_data($data, $filename = 'csv')
csv::read($path, $delimiter = true, $encode = false)

try_unserialize($value)
isSerialized($value)

textTemplate($pattern, $ctx = false, $opts = null)
transliterate($textcyr = null, $textlat = null)
```

CSV output и `outputASJson` могут отправлять headers/body. `unserialize` нельзя
применять к недоверенным данным без отдельного security review.
