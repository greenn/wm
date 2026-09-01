# Coverage этапа =2

Дата инвентаризации: 2026-08-31; финальная сверка: 2026-09-01.

Эта страница фиксирует проверенные знаменатели документации. Она не заменяет
runtime tests и не превращает legacy/unresolved код в current API.

| Область | Проверенное покрытие |
|---|---|
| Agent entry | Корневой `AGENTS.md` + 49 документов `aidocs`; пустых файлов нет. |
| PHP | 408 физических собственных `web/php/**/*.php` вне vendor/node_modules; 395 видимы через ignore-aware `rg`; 126/126 top-level entries перечислены в `php/module-index.md`. |
| PHP symbols | Baseline: 2 393 named function/method definitions по naive scan, 2 612 широких declaration lines и 761 column-zero global functions. Точные public signatures, dependencies и ключевые call chains сведены по entry/family; это не сгенерированный per-method reference. |
| Libraries | Все exact `web/lib/<name>/<name>.php` connector entries отделены от asset-only directories и vendor surface. |
| Named RM | `rb` 26/26, `lay` 6/6, project `gss3` 21/21 matching connectors. |
| Templates | `.blank/r/site` 18/18, `.blank2/r/rb` 25/25 и `.blank2/r/lay` 6/6 matching connectors перечислены либо сгруппированы в project maps. |
| Admin/site | Реальные managers/entries и отсутствующие v2/root targets отмечены как gaps; отсутствующий component не выдан за рабочий. |
| Routing | 48/48 `.htaccess` вне запрещённых зон разобраны по chain/semantic groups; pages v2, legacy, API и admin вынесены отдельно. |
| Links | Все относительные Markdown links внутри `AGENTS.md`/`aidocs` разрешаются. |

## Намеренные границы

- Не читались и не искались `rule/dd/-` и `rule/ai-`.
- Не переносились settings, credentials, tokens, customer data и содержимое
  больших product/catalog JSON.
- Vendor/minified internals не превращались в framework API reference.
- Dot-projects использовались точечно как examples и не входят в commit.
- Runtime smoke suite на этом документационном этапе не заявляется выполненным;
  найденные разрывы записаны в [known-issues.md](known-issues.md).

При изменении loader, route, RM connector, template/source contract или public
helper обновлять соответствующую карту и этот denominator, если он изменился.
