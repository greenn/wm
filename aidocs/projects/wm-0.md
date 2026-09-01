# Project wm-0

Status: planned/unresolved; на момент inventory этапа `=2`
`J:\dv\wm-0` отсутствует.

Target location: `J:\dv\wm-0`.

## Минимальная структура

    J:\dv\wm-0\
    ├── AGENTS.md
    ├── iq.inc
    ├── index.php
    ├── test\
    ├── r\
    │   ├── rb\
    │   └── lay\
    ├── site\
    │   ├── iq.inc
    │   ├── router.php
    │   ├── settings\
    │   └── uv\
    └── <project-rm>\
        ├── iq.inc
        ├── pages\
        ├── router\
        └── r\

`api`, `css`, `fonts`, `i`, `js` и `wd` добавляются только при наличии
consumer.

## Web mode

1. Centralized (default): project не копирует `web`; host-specific
   `site/settings/settings[<domain>].inc` выбирает shared
   `J:\dv\wm\web` через проверенную connector chain.
2. Local: project содержит `web`, а `site/web/web[self].inc` подключает
   `<DOCUMENT_ROOT>/web/web.php`.

Один факт соседства с `J:\dv\wm` не перенастраивает `ROOT/r/rb` и
`ROOT/r/lay`, поэтому стандартные resource roots копируются явно.

## Gate готовности

- bootstrap/index без fatal;
- base/normal page, 404 и `is-mod`;
- project handler и `rMain` page shell;
- по одному template `rb`, `lay` и project RM;
- root API GET + mutating/error/auth cases;
- CSS/JS/image/font + `qv()`;
- Vue 3 client route, back/forward/direct reload;
- WD preset, если UI сверяется;
- никаких secret settings/product JSON в Git.

До создания это только contract, не runnable project.
