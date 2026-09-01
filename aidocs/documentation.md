# Карта документации

| Источник | Аудитория | Назначение |
|---|---|---|
| `AGENTS.md` | Codex | Короткие правила почти для каждой задачи. |
| `aidocs` | Codex/разработчик | Exact paths, symbols, flows, risks и checks. |
| `rule/ai` | Исполнитель этапов | Нормализованные решения и задания владельца. |
| `man/wm` | Человек | Current автономный Documentation Site framework. |
| `man/site`, `man/admin*`, `man/rm/*` | Человек | Конкретные pages/admin/RM. |
| `man/sug` | Владелец | Нумерованные предложения до approval. |
| `man/log` | История | Задания и результаты. |

Правило синхронизации: изменение public behavior/route/component/template/helper
обновляет соответствующую карточку `aidocs`. После создания `man` human
изменение отражается и там. Не копировать один и тот же длинный текст: agent
docs дают точность, human docs — объяснение и навигацию.

Legacy и old `man` используются только как источник терминов. Любое
неподтверждённое утверждение получает status `legacy` или `unresolved`.

## Documentation Site runtime

```text
man/index.php
  -> assets/app.js
  -> man/content.php
  -> manifest.json whitelist
  -> structured Markdown under man
```

Сайт не подключает IQ/RM и не требует Node/build. API принимает только GET и
document ID из manifest, повторно проверяет `realpath`, containment, extension
и размер. Raw HTML в Markdown экранируется; внешние runtime dependencies не
используются. Техническая карта реализации: `man/README.md`.
