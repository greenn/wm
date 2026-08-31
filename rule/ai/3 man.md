# Human-facing Documentation Site

`man` — автономный Documentation Site, не зависящий от runtime IQ/RM текущего
сайта. Основная документация framework хранится в `man/wm`.

Структура:

```text
man/
├── wm/
├── site/
├── admin/                 # либо admin2/kot по имени конкретной системы
├── rm/
│   ├── rb/
│   ├── lay/
│   ├── site/
│   └── <project-rm>/
├── sug/
└── log/
```

Контент хранится в Markdown и тематических подпапках. Для страницы указываются
URI, PHP-router, page data, RM/components/templates, assets, client routes и
история изменений. Для RM — manager, components, API, templates и consumers.

UI ориентируется на `rule/ai/4 man-ui.png`: левая навигация, читаемая
центральная колонка, правая область примеров там, где она полезна, notice-блоки
и syntax-highlighted code. Логотип кликабелен и ведёт на титульную страницу,
неочевидные действия имеют title/tooltips, загрузки и ошибки логируются в
console без секретов.

`man/sug` содержит только предложения со сквозными номерами; реализация
начинается после approval. `man/log` хранит нормализованные задания и краткие
результаты по правилам `0 log.txt`.
