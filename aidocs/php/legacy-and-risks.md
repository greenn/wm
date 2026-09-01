# Legacy, conflicts и unresolved contracts

## Правило

Наличие файла в `web/php` не доказывает, что он доступен через current loader,
совместим с v2 или безопасен для нового consumer-а. Здесь зафиксированы
фактические расхождения, найденные при инвентаризации; это не команда исправить
их в рамках документационного этапа.

## Loader/path mismatches

`need::php($name)` строит ровно `web/php/$name.php`. Он не добавляет `.class`,
не удаляет `-` и не интерпретирует `:`. Поэтому следующие ссылки требуют
отдельной проверки или исправления в своей задаче:

| Referencing file / name | Фактическое состояние | Риск |
|---|---|---|
| `web/php/site.php` -> `site/web_r.class` | `web/php/site/web_r.class.php` отсутствует | top-level `site.php` не является рабочим v2 IQ entry |
| `web/php/mysql.php` -> `mysql/sd.class` | target отсутствует; отдельный `web/php/sd.php` существует | aggregator incomplete |
| `web/php/j.php` -> `json/l/jc` | target отсутствует | JSON facade может зависеть от внешнего/bootstrap legacy state |
| `web/php/isAssoc.php` -> `isOrdinal` | отдельного `isOrdinal.php` нет; `isOrdinal()` объявлен в самом `isAssoc.php` | ошибочный self-family request |
| `web/php/ghtml.php` -> `ghtml/gh`, `ghtml/gs` | существуют `gh.class.php`, `gs.class.php` | exact loader не найдёт targets |
| `web/php/dirUrl.php` -> `php` | существует `php-.php`, не `php.php` | dynamic sugar dependency unresolved |
| `web/php/sendMail.php` -> `prop` | существует `prop.class.php`, не `prop.php` | mail helper dependency unresolved |
| `web/php/_h.class.php` -> `x/x_` | существует `x.class/_x.php`, не `x/x_.php` | HTML helper dependency mismatch |
| `web/php/ar.php` -> `ar/ar_item.class` | target отсутствует | placeholder subsystem incomplete |
| legacy `wr:2` notation | current `need::php()` не парсит `:` | историческая идея, не current contract |

Некоторые строки `_needphp('lib')`/старых loader names встречаются только в
comments или legacy files; не считать их runtime failure без проверки точной
исполняемой ветки.

## Conflicting declarations

Следующие варианты нельзя подключать одновременно без redeclaration fatal:

- `web/php/r.php` и `web/php/r2.php` — оба объявляют `r`, `R`, `RC`;
- `web/php/css/clamp.php` и `web/php/css/clamp1.php` — одинаковые `_clamp*`;
- `web/php/parser/strTabMenuParser.class.php`, `.v1-5.class.php`,
  `.v1.class.php` — один class name;
- `web/php/site/v1/r/app.class.php` и `app.class.v1.php` — `app`, `_app`,
  global facades;
- `web/php/site/v1` и `site/v2` повторяют page, language, CSS, image, resource
  и router names;
- `web/php/page.php` объявляет legacy class `page`, который может конфликтовать
  с site page implementation;
- `web/php/fq/- d/attr_val*.php` содержит alternate definitions;
- `web/php/addphp-.php` и `need/need.class.php` представляют разные loader
  generations.

Новый код начинает с current v2 chain и не «подключает всё».

## Legacy markers

Сильные, но не абсолютные признаки legacy:

- suffix/prefix `-`, `-b`, `- d`, `d`, `dd`;
- `.v1`, `v1/`, `*.b.php`, `*.D.php`;
- `test`, `eg`, `tpl`/router execution fragments;
- comments о prototype/плохой функции;
- одноимённые более новые v2 files.

Только имя не заменяет проверку consumer-а. Например `web/php/file.php` стар по
стилю, но имеет реальные current utility uses; `site/v1` явно legacy для нового
кода, хотя может оставаться активным в старом проекте.

## Current v2 boundary

Для нового проекта current environment начинается с `iqSite`/`iqPro` в
`web/php/site/v2/iq`, а не с top-level `web/php/site.php`. PHP server router
остаётся точкой истины initial page/reload. v1 page/router/resource helpers
документируются для сопровождения, но не копируются в новый проект.

`site/v2/r/{rt,rb,lay}.class.php` — framework compatibility/runtime classes;
они не отменяют project RM connector `<component>.class.inc`.

## Side-effect risks

| Область | Что проверить перед вызовом |
|---|---|
| `file/*`, `J`, `crud_json`, `log` | абсолютный path, containment, permissions, backup/locking, concurrent writes |
| `headers`, `redirect*`, CSV/JSON output | headers already sent, cache semantics, termination, response content type |
| `htmlByUrl` | SSRF boundary, timeout, TLS, response size/status |
| `sendMail` | recipient/header injection, credentials/config, unresolved dependency |
| `mysql`, `sd`, `ptf` | connection source, secrets, parameterization, transaction/error behavior |
| image/GD | MIME, decompression/memory size, destination path, extension availability |
| templates/includes | trusted path; context variable collision; output buffering cleanup |
| session/cookie | session lifecycle, SameSite/Secure/HttpOnly, headers state |
| `unserialize` | недоверенный serialized input запрещён без security review |

## Debug/output helpers

`dog`, `dbg`, `rem`, `notch`, `log`, Kint aliases и `dx` могут выводить data,
headers, stack traces или останавливать execution. Они не должны печатать
credentials, tokens, cookies, full product JSON или personal data.

`console.log` включён по умолчанию для frontend diagnostics по решению
владельца, но это не разрешает перенос server secrets в generated JS.

## `w()` / `wb()`

`web/php/w.php` и `web/php/w/**` — Russian morphology/word bank:

```php
w($name, $case = null, $opt = null)
wb($word = null, $forceUpdate = false)
```

Это legacy language subsystem, не будущий WebBuilder app. Не переименовывать
существующие functions и не выводить из них API WebBuilder.

## Compatibility

- Target runtime — PHP 7.2, `short_open_tag=On`.
- В новом framework PHP использовать короткие tags.
- Не добавлять PHP 7.3+ syntax/functions без согласованного polyfill.
- В дереве встречаются variadics и старый код с dynamic/static patterns;
  проверять lint и конкретный call chain, а не только syntax scan.
- Vendor upgrades и массовое исправление legacy не входят в обычный helper
  change.

## Как разрешать `unresolved`

1. Найти точного runtime consumer-а без массового обхода закрытых данных.
2. Подтвердить bootstrap и фактический loader name.
3. Воспроизвести минимальный call на PHP 7.2 с short tags.
4. Выбрать: исправить path, заменить consumer current API или оставить legacy.
5. Не создавать alias-файл автоматически: он может вызвать duplicate class/
   function declarations.
6. После решения обновить status и call chain в `aidocs/php`.
