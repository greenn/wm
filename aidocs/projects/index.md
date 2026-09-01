# Projects и ownership

Status: current policy.

WM root `J:\dv\wm` предоставляет framework contracts, shared `web`, resource
bases, blanks, rules, `man` и `aidocs`. Прикладной project владеет своей
инициализацией, entry, tests, project RM и прикладными assets/data.

## Project-owned

| Путь | Обязательность |
|---|---|
| `AGENTS.md` | Обязателен, короткие локальные правила. |
| `iq.inc`, `index.php` | Обязательные bootstrap/HTTP entry. |
| `test/` | Обязательный default для URL smoke/dev examples. |
| `<project-rm>/` | Pages, router, components, templates и project data. |
| `api/ css/ fonts/ i/ js/ site/ wd/` | Только по реальной потребности. |
| `site/settings/` | Host-local; секретные значения не коммитятся. |
| `site/uv/` | Canonical, commit-managed URL-version databases. |

Standard copied framework resources: `r/rb` и `r/lay`. `rb` обязателен;
`lay` архитектурно optional, но входит в default bundle владельца до dependency
audit.

Shared `web` и `man` не копируются в новый project при centralized mode.

## Карты

- [wm-0.md](wm-0.md) — planned sibling project.
- [vmk4-gss3.md](vmk4-gss3.md) — current structural example и blockers.
- [dot-projects.md](dot-projects.md) — excluded overlays.
- [blanks.md](blanks.md) — committed `.blank/.blank2`.
- `aidocs/testing/index.md` — test locations и smoke suite.

Перед копированием каждого каталога назвать consumer. Не переносить project
целиком, product JSON, settings, credentials, logs, caches или dumps.
