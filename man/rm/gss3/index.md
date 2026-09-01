# GSS3 — project RM примера

`.vmk4/gss3` показывает project environment, RM, pages, router, templates и
assets. Структура полезна, но runtime имеет известные gaps и не копируется
целиком.

Manager/environment: `.vmk4/gss3/php/gss3.env.php`. `_gss3::rDir()` возвращает
`ROOT.'/gss3/r'`; helpers — `gss3()`, `gss3_tpl()` и `gss3_api()`.

## Components — 21

```text
addresses, app, banner, blank, catalog, contacts, content, css,
footer, header, info, logo, marquee, menu, page, plan, search,
sys-msg, top-menu, uc, ui
```

Каждый component имеет connector
`.vmk4/gss3/r/<component>/<component>.class.inc`. Support files
`catalog-data.class.inc` и `uc-overlay.class.inc` остаются частью owner
component.

## Pages и resources

Pages: `404`, `agent`, `catalog`, `contacts`, `docs`, `index`, `service`.
Project handler: `.vmk4/gss3/router/mod.php`.

Project environment также определяет `css_gss3`, image handler `i_gss3`,
`pages_gss3`, component templates/CSS/JS и WD resources. Matching component
API routes в scoped inventory не подтверждены.

## Почему это не blank

- local `web` отсутствует;
- `dirSelf` используется как absolute path;
- CSS `%sid` не раскрывается;
- router path/context расходятся;
- `pages/.map.inc` отсутствует;
- local `r/rb` и `r/lay` отсутствуют;
- settings и product JSON не переносились.

Новый project берёт отсюда состав и ownership, а contracts исправляет
отдельными проверяемыми изменениями.
