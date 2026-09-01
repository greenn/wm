# WM aidocs

Agent-first карта текущего WM. Начинай здесь после корневого `AGENTS.md`.
`aidocs` даёт точные entry points и ограничения; human-facing объяснения будут
жить отдельно в `man/wm`.

## Быстрый маршрут

1. [Архитектура WM](architecture/overview.md) — границы и
   request/resource flows.
2. [Bootstrap и IQ](architecture/bootstrap-iq.md) — `web`, site/project IQ и
   два web-mode.
3. [Routing](routing/index.md) — pages v2/legacy, API, admin и `.htaccess`.
4. [Resources](resources/index.md) — resource layer, connectors, named RM и
   templates.
5. [PHP-карта](php/README.md) — полный индекс верхнеуровневых `web/php`,
   function families и call chains.
6. [Assets](assets/index.md) — CSS/JS, fonts, images, Vue, `wd`, `mqr`, `uv`.
7. [Projects](projects/index.md) — ownership, dot-projects, blanks и `wm-0`.
8. [Testing](testing/index.md) — проверка нового кода и smoke matrix.
9. [Known issues](known-issues.md) — подтверждённые расхождения, которые нельзя
   чинить попутно.
10. [Coverage этапа =2](coverage.md) — проверенные знаменатели и границы карты.

Рабочий процесс и документация: [workflow.md](workflow.md),
[documentation.md](documentation.md). Термины: [glossary.md](glossary.md).
Неактивированные варианты skills/hooks/MCP:
[tooling-options.md](tooling-options.md).

## Статусы

- **current** — подтверждено текущим v2 и рекомендуется для нового кода;
- **legacy** — существует для совместимости, не копируется как новый шаблон;
- **blank** — заготовка, требующая проверки;
- **unresolved** — решение владельца и implementation расходятся либо contract
  неполон;
- **planned** — согласованное направление без утверждённого API.

## Как пользоваться

Ищи точный symbol/path по этой карте, затем проверяй definition и consumer в
коде. Документация не заменяет scoped исследование. При обнаружении расхождения
обновляй status/known issues, не исправляй архитектуру без задания.
