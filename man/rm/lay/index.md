# LAY — элементы компоновки

Named RM `lay` хранит небольшие повторно используемые layout primitives.
Manager: `web/php/site/v2/r/lay.class.php`; root: `<ROOT>/r/lay`.

Helpers: `_lay::req()`, `lay()` и `lay_tpl()`. Connector:
`r/lay/<name>/<name>.class.inc`.

## Components — 6

| Component | Templates и статус |
|---|---|
| `blank` | Заготовка component/template. |
| `button` | `r-button-1` и связанные CSS variants. |
| `flex` | `2-cols-grow-first.tpl.php`. |
| `menu` | Только `draft1`; status unresolved. |
| `pic` | `img` и `split-3d-*`, image context helper. |
| `text` | `vmk-text-*`, text parser; `LayContentsMenu` incomplete. |

`lay::tpl('name')` сначала пробует nested path
`<component>/name/name.tpl.php`, затем обычный `<component>/name.tpl.php`.

`lay` не обязателен каждой странице, но входит в стандартный project bundle.
Project-specific section не переносится сюда только ради формального DRY.
