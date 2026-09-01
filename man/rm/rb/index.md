# RB — базовые ресурсы WM

`rb` — обязательный базовый named RM. Manager находится в
`web/php/site/v2/r/rb.class.php`, root — `<ROOT>/r/rb`, connector —
`r/rb/<name>/<name>.class.inc`.

Public helpers: `_rb::req()`, `rb()` и `rb_tpl()`.

## Components — 26

| Группа | Components | Назначение |
|---|---|---|
| Page/routing | `page`, `page-content`, `router2`, `router` | Shell, content и handlers; `router` legacy. |
| Frontend | `css`, `vue`, `aos`, `drozd`, `mqr` | Styles, Vue/source и optional scaler. |
| SEO/HTTP | `seo`, `robots-txt`, `sitemap` | Metadata и URL files; sitemap legacy/unresolved. |
| Data/integration | `data`, `json`, `bz`, `db`, `api`, `tgbot`, `xls`, `yamap` | Data/API integrations с разным уровнем готовности. |
| Layout/dev | `lay`, `wd`, `uc-upd` | Block helper, visual compare и time utility. |
| Template | `blank` | Component-заготовка. |
| Support | `chartjs`, `dbg` | Неполные/диагностические wrappers. |

Полный алфавитный список:

```text
aos, api, blank, bz, chartjs, css, data, db, dbg, drozd,
json, lay, mqr, page, page-content, robots-txt, router, router2,
seo, sitemap, tgbot, uc-upd, vue, wd, xls, yamap
```

## Важные границы

- Root `api/index.php` не равен component `r/rb/api`.
- `router2` — current pages v2, `router` — legacy.
- `r/rb/lay` не равен named RM `lay` из `r/lay`.
- `vue` содержит current engine и mixed Vue 2/3 test corpus.
- `page-content` default `site` зависит от ещё не реализованного v2 RM.
- `tgbot` требует security review.
- `chartjs.class.inc` содержит лишний token `USB` и не подключается до fix.

Top-level `-ui`, `grid`, `grid-`, `log`, `system-`, `test` и `tool` не имеют
matching connectors и не являются components `rb`.
