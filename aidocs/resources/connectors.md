# IQ, library и RM connectors

Status: current.

## Три цепочки

| Вид | Entry | Вызов/инициализация | Результат |
|---|---|---|---|
| IQ сайта | `site/iq.inc` | `_iq::add_site(...)` | Регистрирует `iqSite`, host/settings/router/uv. |
| IQ проекта | `<project>/iq.inc` | `_iq::add_pro(...)` | Регистрирует `iqPro`, env, paths и `rMain`. |
| Library | `web/lib/<name>/<name>.php` | `_lib('<name>')` | Один раз подключает библиотеку через `need::lib()`. |
| RM component | `<rm-root>/<name>/<name>.class.inc` | `_<rm>::req('<name>')` | Регистрирует component, class и config в manager RM. |

IQ не регистрирует component. Library entry не является RM class. RM connector
не является bootstrap сайта.

## RM connector

Manager строит имя entry в
`web/php/rw/_rw.class.php::_rw::rClass()`. Обычная цепочка:

    rb('page', 'favicon', $cfg)
      -> _rb::name('page')
      -> _rb::req('page')
      -> r/rb/page/page.class.inc
      -> _rb::reg('page', ...)
      -> rb_page::favicon($cfg)

Проверять перед документированием:

1. имя директории совпадает с basename `*.class.inc`;
2. `reg()` использует то же component name;
3. class соответствует `manager::className()` либо явно задан в config;
4. templates/support dirs без собственного connector не добавлены в список
   components.

## Library connector

Реализация: `web/php/need.php::_lib()` →
`web/php/need/need.class.php::need::lib()`. Подтверждённые entries:

| Имя для `_lib()` | Entry | Status |
|---|---|---|
| `kint` | `web/lib/kint/kint.php` | current |
| `mobile-detect` | `web/lib/mobile-detect/mobile-detect.php` | current |
| `mpdf` | `web/lib/mpdf/mpdf.php` | current |
| `PhpSpreadsheet` | `web/lib/PhpSpreadsheet/PhpSpreadsheet.php` | legacy name, current entry |
| `ptf` | `web/lib/ptf/ptf.php` | current entry |
| `simple_html_dom` | `web/lib/simple_html_dom/simple_html_dom.php` | legacy name, current entry |
| `simple-scrollbar` | entry `web/lib/simple-scrollbar/simple-scrollbar.php` отсутствует | unresolved/support only |

Новые library names используют kebab-case. Существующие legacy names не
переименовывать. Не заменять `_lib()` на `_needphp()`.

## IQ connector

Точные current classes находятся в `web/php/site/v2/iq/`. Перед запуском
проверить реальный `DOCUMENT_ROOT`, выбранный local/shared web, `selfDir`,
`pagesDir`, `routerDir`, `rMain` и зарегистрированные env handlers. Пример
`.vmk4/gss3/iq.inc` содержит известные расхождения и не копируется как готовый
blank; см. [gss3.md](gss3.md).
