# Bootstrap и loaders

## Каноническая начальная цепочка

`web/web.php` является bootstrap общего `web` (отдельная версия `19.2.11`). Он:

1. определяет request/path constants, включая `ROOT`, `WEB`, `PHP`, `LIB`,
   `INC`, `URI`, `pageUri`, `hostUrl`;
2. выполняет `include_once PHP.'/need.php'`;
3. подключает Kint вызовом `_lib('kint')`.

Следовательно, базовый loader доступен после `web/web.php`; произвольный
`web/php/*.php` не считается загруженным только потому, что файл существует.

## Current loader API

Точные определения находятся в `web/php/need.php` и
`web/php/need/need.class.php`.

```php
function _needphp(/* $phpName1, ..., $phpNameN */)
function _addphp($phpName)
function _lib($phpName)
function _needinc($incName)

need::php($phpName)
need::pro($phpName)
need::path($phpName, $dirPath = false)
need::lib($libName)
need::inc($incName)
need::get_info()
```

Разрешение путей точное:

| Вызов | Получаемый путь |
|---|---|
| `_needphp('fq')` | `PHP.'/fq.php'` |
| `need::pro('x')` / `need_pro('x')` | `need::$pro.'/x.php'`, default `iq/php/x.php` |
| `need::path('x', $dir)` | `$dir.'/x.php'` |
| `_lib('kint')` | `LIB.'/kint/kint.php'` |
| `_needinc('x')` | `INC.'/x.inc'`; имя с suffix `.php` остаётся `.php` |

Внутренний `need::_php()` проверяет `is_file`, делает `include_once`, ведёт
`need::$list` и `need::$order`; отсутствующий путь также попадает в order с
префиксом `!`. Повторный запрос не исполняет файл второй раз, но увеличивает
tracked count.

`_addphp()` в current loader — только alias к `need::php()`. Не путать с
историческим standalone `addphp()` из `web/php/addphp-.php`.

## Aggregator pattern

Файл семейства обычно загружается так:

```php
<? _needphp('file'); ?>
```

`web/php/file.php` затем вызывает `_addphp('file/save_file')` и другие
локальные helpers. Аналогично устроены `fq.php`, `json.php`, `str.php`,
`rw.php`, `img.php`, `bz.php`. Однако наличие aggregator-а ещё не означает,
что все его targets существуют: известные расхождения перечислены в
[legacy-and-risks.md](legacy-and-risks.md).

## Project и environment loading

`web/php/need/need_pro.php` определяет:

```php
function need_pro(/* $phpName1, ..., $phpNameN */)
```

Он делегирует каждый аргумент `need::pro()`. Directory задаётся через
`need::$pro`; default — относительный `iq/php`. Для v2 IQ фактические entry
находятся под `web/php/site/v2/iq`; их lifecycle задают `iqSite` и `iqPro`, а
не generic `_needphp()` по догадке.

## Legacy loaders

| Файл | API | Статус |
|---|---|---|
| `web/php/addphp-.php` | `addphp($phpName)` и globals `_webphpList`, `_webphpOrder` | legacy tracker до `need` |
| `web/php/needphp-.php` | `needphp(/* names */)` | legacy wrapper над старым `addphp()` |
| `web/php/php-.php` | `php($phpName, ...$args)`, `_sphp($callChain, ...$args)` | legacy dynamic load/call sugar |
| `web/php/lib-.php` | `lib($libName)` | legacy connector; не заменяет `_lib()` |
| `web/php/need/need.v2.b.php` | `need(/* names */)` | legacy/prototype; сам комментарий называет попытку загрузить всё подряд плохой |
| `web/php/-/phpinc.php` | `phpinc($incName, $incArguments = 0)` | archived/legacy path |

Новый код использует `_needphp()`/`need` и `_lib()`. Не переносить
`php('call1 call2', ...)`, `need()` или dash-варианты без доказанного legacy
consumer-а.

## Include helpers — не loaders модулей

```php
// web/php/inc.php
inc($path, $res_type = INC_RES_AS_IS, $_ctx = array())
inc_data($path, $ctx = array(), $res_type = INC_RES_AS_DATA)
inc_self($path, $res_type = INC_RES_AS_IS, $ctx = array())
inc_root($path, $res_type = INC_RES_AS_IS, $ctx = array())

// web/php/inc.class.php
inc::raw($path/*, $ctx */)
inc::data($path/*, $ctx */)

// web/php/webinc-.php / webreq-.php
webinc($incPathName, $set = array(), $reuse = true)
webreq($incPathName)
```

`inc*` исполняют выбранный файл с context/output semantics; это отличается от
регистрации PHP helper-а через `need`. `webinc-`/`webreq-` строят путь внутри
`WEB.'/inc'` и помечены legacy.
