# Assets и data

Status: current map with legacy/unresolved entries called out.

## Root directories

| Путь | Роль | Важная граница |
|---|---|---|
| `api/` | HTTP API entry, не frontend asset | Маршрутизация документируется отдельно; не подключать как script. |
| `css/` | Vendored/static CSS providers | Component CSS чаще находится рядом с RM component. |
| `fonts/` | Font files и PHP-generated CSS endpoints | License и реальные paths проверяются по family. |
| `i/` | Default static image root для `_i::...` | Project image env может иметь другой root. |
| `js/` | Vendored/static browser libraries | Это не `web/lib` и не `_lib()`. |
| `site/` | Site environment, settings, router и canonical UV | `site/settings` закрыт; `site` не просто asset dir. |
| `wd/` | URL entry visual-diff tool | Dev only. |
| `site/uv/` | Canonical URL-version databases | Корневой `uv/` — legacy/noncanonical. |

## Карты

- [css-js.md](css-js.md) — source manager, CSS/JS и vendored versions.
- [fonts.md](fonts.md) — font entries, files, license/runtime gaps.
- [images.md](images.md) — `_i()` против `_i::...`.
- [vue.md](vue.md) — Vue 3 source pairs и legacy corpus.
- [wd.md](wd.md) — reference/live visual verification.
- [mqr.md](mqr.md) — optional runtime scaler.
- [uv.md](uv.md) — `qv()` и databases.
- [data-sources.md](data-sources.md) — PHP/text/JSON/DB/API policy.

Общий frontend build pipeline отсутствует и не требуется. Не добавлять
npm/Vite/Webpack только для подключения одного ресурса.
