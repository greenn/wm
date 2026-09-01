# Named RM lay

Status: current v2 inventory with unresolved draft parts.

Manager: `web/php/site/v2/r/lay.class.php`.
Root: `<ROOT>/r/lay`.
Base class: `lay extends rt`.
Helpers: `lay()`, `lay_tpl()`, `_lay::req()`.

`lay::tpl('name', ...)` сначала пробует
`<component>/name/name.tpl.php`, затем обычный
`<component>/name.tpl.php`.

## Components — 6/6

| Component | Status | Connector | Подтверждённые ресурсы/contract |
|---|---|---|---|
| `blank` | blank | `r/lay/blank/blank.class.inc` | `blank.tpl.php`, `blank-1.css.php` и `-blank.js.php` как заготовка. |
| `button` | current structural | `r/lay/button/button.class.inc` | Nested template `r-button-1/r-button-1.tpl.php` и CSS variants; context включает `text`, `nc`, `ft`, `nobr`, `@click`. |
| `flex` | current | `r/lay/flex/flex.class.inc` | `2-cols-grow-first.tpl.php` с context `content1`, `content2`, `nc`. |
| `menu` | unresolved draft | `r/lay/menu/menu.class.inc` | Единственный template `draft1.tpl.php` сам загружает `blank` CSS; не использовать как canonical menu. |
| `pic` | current structural | `r/lay/pic/pic.class.inc` | `applyCtx()`; `img.tpl.php` и `split-3d-1`/`split-3d-1b`/`split-3d-2` templates + CSS. Image fallback использует `_i::uri()/h()`. |
| `text` | current + incomplete support | `r/lay/text/text.class.inc` | `toHtml()/text2html()`, `vmk-text-1` и `vmk-text-gal` templates/CSS, paragraph parser. `LayContentsMenu.class.php` не завершает построение items и считается unresolved. |

`lay` архитектурно не обязателен каждой странице, но входит в стандартный
копируемый набор нового проекта. `r/lay` и component `r/rb/lay` — разные
namespaces.
