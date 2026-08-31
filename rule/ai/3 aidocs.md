# aidocs

`aidocs` — внутренняя agent-first документация для Codex. Она не должна
дублировать весь human-facing `man/wm`: её задача — быстро привести агента к
точному contract и нужному файлу.

Рекомендуемая карта:

```text
aidocs/
├── start.md
├── architecture/
│   ├── bootstrap-iq.md
│   ├── resource-layer.md
│   ├── pages-router.md
│   └── api-router.md
├── rm/
│   ├── rb.md
│   ├── lay.md
│   ├── site.md
│   └── <project-rm>.md
├── php/
├── assets/
├── projects/
├── testing/
├── legacy/
└── known-issues.md
```

Каждая карточка содержит: status (current/legacy/blank/planned), назначение,
entry point, точные пути, public calls, dependencies, consumers, ограничения и
реальную проверку. Для RM перечисляются только components с
`<component>.class.inc`; для PHP-функций показываются подфункции/call chains;
для `.htaccess` — полный URL-to-handler flow.

Корневой `AGENTS.md` должен оставаться коротким и ссылаться сюда. Секреты,
settings values и содержимое product JSON в `aidocs` не переносятся.
