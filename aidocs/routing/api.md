# Root API router

Статус: current root router с каноническим endpoint naming. Snapshot содержит
несколько gaps, поэтому расширять доступные RM по догадке нельзя.

## Точки входа и symbols

- Apache front controller: `api/.htaccess`;
- HTTP entry: `api/index.php`;
- router/resource: `api/api.class.inc`, class `rt_api`;
- client/internal helper: `api/_api.class.php`, class `_api`;
- resource primitives: `web/php/site/v2/r/rt.class.php`,
  `web/php/rw/rw.class.php`, `web/php/rw/_rw.class.php`;
- optional alternate API implementation: `web/php/api/api.class.php` — это
  другая token/config модель, не путать с root `rt_api`.

`api/.htaccess` переписывает любой непустой relative path на `api/index.php`.
Корневой project `.htaccess` обычно пропускает физический каталог `/api`, после
чего срабатывает этот per-directory файл.

## URL и endpoint resolution

Ожидаемая форма HTTP URL:

```text
/api/<rm-env>/<component>/<route>
```

Например, после явного разрешения RM `site`:

```text
GET /api/site/menu/list
  -> api/index.php
  -> rt_api::request('menu/list', data, 'GET', 'site')
  -> _site::req('menu')
  -> <site-r-root>/menu/api/list.get.inc
     fallback <site-r-root>/menu/api/list.inc
```

Алгоритм `rt_api::request()`:

1. Первый segment переданного `requestUri` — component (`$rName`), остаток —
   route (`$api`).
2. Динамически вызывается manager `_<rm-env>::req($rName)`; component должен
   быть зарегистрирован connector-файлом `<component>.class.inc`.
3. Строятся paths `api/<route>.<lower-method>.inc` и `api/<route>.inc` внутри
   component root.
4. Method-specific endpoint имеет приоритет; общий endpoint — fallback.
5. Endpoint вызывается resource method `call` с request data как context.
6. Отсутствующий endpoint даёт error `Wrong Api method`; отсутствующий
   component — `Wrong Api`.

Nested route допустим: `forecast/aggregate` соответствует
`api/forecast/aggregate.post.inc`. Новое API использует настоящий HTTP method;
legacy prefix `/api/get/...`, `/api/post/...` и т. п. оставлять только для
явной совместимости.

## Разбор входных данных current router

| Request | Current source |
|---|---|
| GET и обычные начальные данные | `$_REQUEST` |
| non-multipart POST/PUT/PATCH/DELETE | `parse_str(php://input, ...)` |
| `multipart/form-data` | PHP form/files handling; raw body не reparsed |
| точный `Content-Type: application/json` | `json_decode(php://input, true)` |

Router определяет JSON presence через substring, но фактически декодирует
только при точном равенстве header строке `application/json`. Значение с
`charset`, например `application/json; charset=utf-8`, current code не
декодирует — это gap, который должен иметь regression test.

## Ответ

`rt_api::output()` вызывает CORS configuration, затем по умолчанию
`outputJson()`: JSON, UTF-8, `nosniff`, pretty encoding. Сам router не переводит
`Wrong Api`/`Wrong Api method` в надёжные HTTP 404/405. Endpoint либо будущий
central error mapper должен выставлять согласованный status; успешная JSON
форма также фиксируется в контракте конкретного API.

Короткий endpoint возвращает data, а не печатает debug:

```php
<?
return array(
    'items' => array(),
);
```

Фактическая response envelope зависит от вызываемого API helper/endpoint;
нельзя обещать `data/success/error`, не проверив consumer.

## Current allow-list gap

В `api/index.php` переменная `$r_list` сейчас равна `array('admin', 'site')`.
Только для этих prefix первый segment удаляется из `requestUri`. При этом `$r`
в любом случае передаётся дальше в `rt_api::response()`, а `rt_api::request()`
строит динамический вызов `_<rm-env>::req(...)`.

Это не полноценная проверка доступа: неизвестный prefix не отклоняется явно,
а меняет разбор component/route. Одновременно `.vmk4/gss3` публикует frontend
base `/api/gss3`, хотя `gss3` отсутствует в `$r_list`; такая цепочка не должна
считаться рабочей.

Целевое исправление должно отдельно:

1. объявить точный allow-list RM для конкретного проекта;
2. при неизвестном RM немедленно вернуть 404/403 без динамического class call;
3. после разрешённого prefix однозначно выделить component и route;
4. покрыть `/api/site/...`, project RM и unknown RM интеграционными tests.

Не расширять `$r_list` просто ради прохождения одного URL: сначала подтвердить
bootstrap, manager class, connector и server-side authorization.

## Безопасность endpoint

- Валидировать route segments, payload, content type и допустимый HTTP method.
- Authentication и authorization выполнять на сервере в каждом защищённом
  действии либо в проверенном central middleware.
- `_api` helpers и `access_token=true` для внутреннего PHP-вызова не являются
  доказательством подлинности внешнего HTTP request.
- Для cookie/session mutations нужен CSRF control; CORS его не заменяет.
- CORS origin/method/header задавать минимально; credentials нельзя сочетать с
  произвольным origin.
- Не возвращать SQL, absolute filesystem path, stack trace, settings или token.
- Debug разрешён только в безопасной local среде; current `rt_api::$dbg` в
  entry принудительно выключен, это не отменяет debug внутри endpoint.
- Ошибки должны иметь реальные HTTP statuses (минимум 400/401/403/404/405/422/
  500 по контракту), а не только поле JSON.

## Checks для нового/изменённого route

1. PHP 7.2 lint с `short_open_tag=On` для connector и endpoint.
2. Реальный METHOD выбирает `<route>.<method>.inc`; отсутствующий method
   проверяет осознанный fallback `<route>.inc` либо 405.
3. Проверить form-urlencoded, JSON с/без charset и multipart, если они входят в
   контракт.
4. Проверить unknown RM/component/route и invalid payload с status + JSON.
5. Проверить guest, authenticated user и недостаточные права.
6. Проверить, что response не содержит debug/paths/secrets и CORS не шире
   необходимого.
