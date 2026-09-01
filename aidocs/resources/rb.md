# Named RM rb

Status: current v2 inventory; отдельные строки имеют более узкий статус.

Manager: `web/php/site/v2/r/rb.class.php`.
Root: `<ROOT>/r/rb`.
Base class: `rb extends rt`.
Manager: `_rb extends _rt`.
Helpers: `rb()`, `rb_tpl()`, `_rb::req()`, `_rb::name()`.

## Components — 26/26

| Component | Status | Connector | Назначение и подтверждённые ресурсы |
|---|---|---|---|
| `aos` | current | `r/rb/aos/aos.class.inc` | AOS loader/attribute parser: `req()`, `set_attr()`, `init_js()`; грузит `js/aos/3.0.0b6`, optional Waypoints; локальные примеры в `r/rb/aos/test`. |
| `api` | unresolved | `r/rb/api/api.class.inc` | Пустой component class; `blank.tpl.php` и `router.php`. Это не root API router `api/index.php`; public contract не подтверждён. |
| `blank` | blank | `r/rb/blank/blank.class.inc` | Component-заготовка с `blank.tpl.php`, `blank.css.php`, `blank.js.php`. |
| `bz` | current structural | `r/rb/bz/bz.class.inc` | Подключает `web/php/bz/bz.class.php` — proxy над json/file/mysql backends; собственных методов нет, consumer не подтверждён. |
| `chartjs` | unresolved | `r/rb/chartjs/chartjs.class.inc` | Пустой wrapper; в конце connector присутствует лишний token `USB`. Не подключать до lint/fix и отдельной проверки. |
| `css` | current | `r/rb/css/css.class.inc` | Базовые generated styles: `base.css.php`, `common.css.php`, `flex.css.php`, `reset.css.php`, `aq.css.php`, `ft.css.tpl.php` и подпапки `aq-animation`/`ft`. Использует inherited `req_css()`. |
| `data` | current | `r/rb/data/data.class.inc` | Чтение component-local `*.data.inc`: `getItem()`, `getCacheItem()`, `getDirItems()`, `getItemProp()`. |
| `db` | unresolved/support | `r/rb/db/db.class.inc` | Пустой wrapper; найденные scripts находятся только в `r/rb/db/-` и не образуют public API. |
| `dbg` | unresolved/support | `r/rb/dbg/dbg.class.inc` | Пустой wrapper; `iframes.tpl.php`, `blank.js.php`, `vue-provide/easy-drag.js.inc`. Consumer/runtime не подтверждены. |
| `drozd` | current structural | `r/rb/drozd/drozd.class.inc` | UI resource: `drozd.css.php` и три Vue пары `drozd-bg`, `drozd-pos`, `drozd-rel`; собственных PHP methods нет. |
| `json` | current structural | `r/rb/json/json.class.inc` | Гарантирует `_needphp('json')`; собственных методов нет. Не разрешает массовое чтение product JSON. |
| `lay` | current structural | `r/rb/lay/lay.class.inc` | `block.tpl.php`. Не путать с самостоятельным named RM `lay` из `r/lay`. |
| `mqr` | current optional | `r/rb/mqr/mqr.class.inc` | Формирует `mqr` attributes; `mqr.css.php`, providers v1/v2 и локальные tests. Exact provider проверять у consumer; см. `aidocs/assets/mqr.md`. |
| `page` | current | `r/rb/page/page.class.inc` | Page shell `page.tpl.php`; `favicon()`, `webkit()`; head meta/SEO/OG/favicon templates, body info templates, `webkit/main.inc`. |
| `page-content` | current with gap | `r/rb/page-content/page-content.class.inc` | Нормализует `content/contents/content-tpl` и dispatch-ит templates. Default RM name `site` требует существующего v2 site RM, которого сейчас нет. |
| `robots-txt` | current | `r/rb/robots-txt/robots-txt.class.inc` | `domainUrl()` и templates `open`, `open-2`, `close`, `only-domain`, `only-titul`; `.eg` — examples only. |
| `router` | legacy | `r/rb/router/router.class.inc` | Старый page context/router. Для нового кода использовать `router2` и v2 pages. |
| `router2` | current | `r/rb/router2/router2.class.inc` | v2 page context, SEO/OG/title и handler dispatch; built-in handlers `-/http-404.php`, `-/mod.php`, `-/plain.php`, `-/redirect.php`, `-/site.php`. |
| `seo` | current | `r/rb/seo/seo.class.inc` | `ya_metrika()` и `ya-metrika.tpl.php`; local use выключен по умолчанию. `.b` и snippet — references, не отдельные components. |
| `sitemap` | legacy/unresolved | `r/rb/sitemap/sitemap.class.inc` | Sitemap template и page timestamp helpers, но код использует legacy `cur_iq()`/`_page()`/`site(...)` forms. Проверить до v2 use. |
| `tgbot` | legacy/unresolved | `r/rb/tgbot/tgbot.class.inc` | Telegram request и JSON-backed state. Использует legacy paths, вывод URL в debug и отключает TLS verification; не применять без security repair. |
| `uc-upd` | current utility | `r/rb/uc-upd/uc-upd.class.inc` | Раскладывает временные интервалы/проценты: `apply()`, `apply_list()`, `apply_bundle()`; presets `ctx/*.data.inc`, `upd-page.tpl.php`. |
| `vue` | current + legacy corpus | `r/rb/vue/vue.class.inc` | Vue source/insert helpers, `insert.tpl.php`, `app-init.js.php`, `env.js.php`, `env-js`, `provide`, `s`. Огромные `test/tests/re` содержат Vue 2 и research snapshots; не копировать их как current. |
| `wd` | current dev | `r/rb/wd/wd.class.inc` | Visual diff presets, reference/live UI, opacity/outline commands; `wd.tpl.php` и variants `v1/v1b/v1c`. См. `aidocs/assets/wd.md`. |
| `xls` | unresolved | `r/rb/xls/xls.class.inc` | Пустой wrapper без подтверждённых methods/templates; не путать с `web/lib/PhpSpreadsheet`. |
| `yamap` | current with external dependency | `r/rb/yamap/yamap.class.inc` | Yandex Maps JS v2/v3 loader, static map URL helpers и Vue fragment. API key берётся из project config и не документируется. |

## Не components

В `r/rb` также существуют top-level directories `-ui`, `grid`, `grid-`,
`log`, `system-`, `test` и `tool`. У них нет matching top-level
`<name>.class.inc`, поэтому это support/test/legacy trees. Наличие вложенных
connectors не превращает родительский каталог в component `rb`.

## Проверка изменения

1. Проверить connector и class name.
2. Найти реального consumer.
3. Проверить templates/calls и source dependencies.
4. Для PHP выполнить 7.2 lint с `short_open_tag=On`.
5. Для asset проверить HTTP status, Content-Type и `qv()`.
6. Для shared component проверить обратную совместимость; не менять `rb` ради
   одной project page без необходимости.
