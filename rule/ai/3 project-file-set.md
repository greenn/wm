# Project file set

Новый project состоит только из непосредственно принадлежащих ему файлов и
проверенных копий framework resources.

| Группа | Статус | Назначение |
|---|---|---|
| `AGENTS.md` | project-owned | Короткие локальные правила. |
| `iq.inc`, `index.php` | project-owned, обязательны | Bootstrap и HTTP entry. |
| `test/` | project-owned, обязателен | URL-доступные smoke tests/dev examples. |
| project RM, например `gss3` | project-owned | Pages, router, components, templates и данные проекта. |
| `r/rb` | копируется | Базовый named RM. |
| `r/lay` | стандартно копируется | Layout RM; удалить можно только после dependency audit. |
| `api css fonts i js site wd` | по потребности | Project support/assets/environment. |
| `site/settings` | по потребности, значения локальны | Host-specific configuration; секреты не коммитятся. |
| `site/uv` | canonical и коммитируемый | URL-version databases. |
| `web` | local mode only | В centralized mode используется общий WM web. |
| `man` | не копируется | Остаётся в WM. |

Перед копированием файла надо назвать его потребителя. Запрещено переносить
проект целиком «на всякий случай», settings/credentials, product JSON, logs,
caches, dumps и неиспользуемый legacy.
