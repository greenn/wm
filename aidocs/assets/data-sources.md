# Data sources

Status: current policy; конкретный source определяется owner component.

WM не навязывает единый storage. Допустимы PHP include, text, JSON, database,
HTTP API и другой уже используемый source.

## Подтверждённые формы

| Source | Entry/пример | Правило |
|---|---|---|
| PHP data include | `<component>/*.data.inc` | Вызывать через owner RM `call()`/существующий helper. |
| Directory data | `r/rb/data/data.class.inc` | `getItem()/getDirItems()` читают component-owned `*.data.inc`. |
| Component DB call | `web/php/site/v2/r/rt.class.php::db()` | Разрешает `_db/<method>.inc` owner component; contract проверять отдельно. |
| Root/internal API | `api/index.php` и component `api/<route>.*.inc` | Server auth, validation, stable response/status. |
| JSON | component/project-specific files | Не читать product/catalog JSON массово; сначала paths/count/schema. |
| Database | project/site RM или internal admin API | Выбирать границу по задаче; не унифицировать самовольно. |

## Безопасность

- `site/settings`, tokens, credentials, sessions и dumps не копируются в docs.
- User input валидируется до query/path/API use.
- Output кодируется по HTML/attribute/URL/JS context.
- Writes должны иметь atomic/recovery behavior.
- Test не использует production credentials и не меняет реальные данные.
- Dot-project JSON можно учитывать по paths/counts; content читается только по
  отдельной необходимости.
