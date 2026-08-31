# Результат =1 — нормализация rule/ai

Дата: 2026-08-31
Версия WM: 20.0.2

## Выполнено

- Проверен baseline: commit `09c8abb0b34f61e0cf39c37fcf9acb6ca1f411bc`
  (`chore: исходная база`) находится и в `main`, и в `origin/main`.
- Все 34 разрешённых корневых файла `rule/dd` получили одноимённые версии в
  `rule/ai`.
- Добавлено 37 недостающих тематических документов. Итог: 71 файл —
  70 текстовых и один UI-reference PNG.
- Зафиксированы решения владельца по v2, PHP 7.2/short tags, Vue 3, resource
  layer/RM, трём видам connectors, pages/router, API, admin, project file set,
  двум режимам web, `site/uv`, `wd`, `mqr`, images и placeholder
  WebBuilder.
- Описаны `.vmk4/gss3`, dot-projects, blanks, `wm-0`, `man`, `aidocs`,
  tests, legacy и observed known issues.
- Секретные значения и содержимое product/catalog JSON не переносились.

## Проверено

- покрытие зеркала: 34/34, пропусков нет;
- пустых файлов нет;
- локальные ссылки между документами `rule/ai` разрешаются;
- Markdown code fences сбалансированы;
- high-confidence scoped secret scan не нашёл совпадений;
- `4 man-ui.png` совпадает с источником по SHA-256:
  `1583A30C0DC8D03E5EC43AF1B4DAF5F50AE1FEAF895660CE618F67241EF3411F`.

## Не выполнялось в этом этапе

Known issues из `rule/ai/4 known-issues.md` только задокументированы.
Runtime-код, `.vmk4`, `.blank`, `.blank2`, `wm-0`, `AGENTS.md`,
`aidocs` и Documentation Site не изменялись: это последующие этапы
`=2`–`=5`.

Git-результат этого этапа оформляется одним атомарным commit
`docs: сформировать rule/ai (20.0.2)` и отправляется в `main`.
