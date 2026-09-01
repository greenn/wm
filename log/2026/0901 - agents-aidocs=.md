# Результат =2 — AGENTS.md и aidocs

Дата: 2026-09-01
Версия WM: 20.0.3

## Выполнено

- Создан короткий корневой `AGENTS.md` с обязательными runtime, architecture,
  exclusions, documentation, version и Git rules.
- Создана agent-first карта `aidocs`: architecture/bootstrap, PHP/loaders,
  libraries, routing/pages/API/admin/`.htaccess`, resource layer/RM/templates,
  assets/data, projects/blanks и testing.
- Для `web/php` перечислены 126/126 top-level entries, function families,
  точные ключевые signatures, dependencies, side effects и call chains.
- Подтверждены matching connectors: `rb` 26/26, `lay` 6/6, example project
  `gss3` 21/21, `.blank/r/site` 18/18, `.blank2/r/rb` 25/25 и
  `.blank2/r/lay` 6/6.
- Разобраны 48 `.htaccess` вне запрещённых зон, включая фактические rewrite
  chains и private-data gates.
- Отдельно оформлены предложения по skills, hooks, MCP и subagents; ничего не
  устанавливалось и не включалось.

## Проверено

- 50 Markdown entry/docs (`AGENTS.md` + 49 `aidocs`), пустых файлов нет;
- относительные Markdown links разрешаются;
- Markdown code fences сбалансированы;
- top-level PHP coverage 126/126 и RM/component denominators совпадают с
  matching `*.class.inc`;
- scoped secret/exclusion scan не нашёл переносов закрытых значений;
- `git diff --check` и staged audit выполняются перед commit.

## Ограничения

Документация не выдаёт static regex baseline за PHP-parser/per-method reference
и не заявляет runtime smoke tests. Подтверждённые bootstrap, pages, API, admin,
font и legacy gaps сохранены в `aidocs/known-issues.md` и профильных картах;
runtime-код, blanks и dot-projects в этом этапе не исправлялись.

Git-результат этапа оформляется одним атомарным commit
`docs: добавить AGENTS и aidocs (20.0.3)` и отправляется в `main`.
