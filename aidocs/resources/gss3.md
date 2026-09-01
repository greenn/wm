# Project RM gss3

Status: current structural example; runtime unresolved.

Источник: excluded dot-project `.vmk4/gss3`. Он разрешён для точечного анализа,
но не входит в commits WM и не является готовым blank.

## Manager и helpers

Project environment: `.vmk4/gss3/php/gss3.env.php`.

- `gss3 extends rt` — base component class;
- `_gss3 extends _rt` — manager;
- `_gss3::rDir()` возвращает `ROOT.'/gss3/r'`;
- helpers: `gss3()`, `gss3_tpl()`;
- image env: `i_gss3 extends _img` с root `gss3/i`;
- CSS env: `css_gss3`;
- pages env: `pages_gss3 extends _pages`;
- API adapter: `gss3_api()` / class `gss3_api`.

## Components — 21/21

Каждая строка ниже подтверждена точным connector:

| Component | Entry |
|---|---|
| `addresses` | `.vmk4/gss3/r/addresses/addresses.class.inc` |
| `app` | `.vmk4/gss3/r/app/app.class.inc` |
| `banner` | `.vmk4/gss3/r/banner/banner.class.inc` |
| `blank` | `.vmk4/gss3/r/blank/blank.class.inc` |
| `catalog` | `.vmk4/gss3/r/catalog/catalog.class.inc` |
| `contacts` | `.vmk4/gss3/r/contacts/contacts.class.inc` |
| `content` | `.vmk4/gss3/r/content/content.class.inc` |
| `css` | `.vmk4/gss3/r/css/css.class.inc` |
| `footer` | `.vmk4/gss3/r/footer/footer.class.inc` |
| `header` | `.vmk4/gss3/r/header/header.class.inc` |
| `info` | `.vmk4/gss3/r/info/info.class.inc` |
| `logo` | `.vmk4/gss3/r/logo/logo.class.inc` |
| `marquee` | `.vmk4/gss3/r/marquee/marquee.class.inc` |
| `menu` | `.vmk4/gss3/r/menu/menu.class.inc` |
| `page` | `.vmk4/gss3/r/page/page.class.inc` |
| `plan` | `.vmk4/gss3/r/plan/plan.class.inc` |
| `search` | `.vmk4/gss3/r/search/search.class.inc` |
| `sys-msg` | `.vmk4/gss3/r/sys-msg/sys-msg.class.inc` |
| `top-menu` | `.vmk4/gss3/r/top-menu/top-menu.class.inc` |
| `uc` | `.vmk4/gss3/r/uc/uc.class.inc` |
| `ui` | `.vmk4/gss3/r/ui/ui.class.inc` |

Support files such as `catalog-data.class.inc` and `uc-overlay.class.inc` are
part of their owner component; они не становятся отдельными components.

## Pages и router

Page entries:

    .vmk4/gss3/pages/404.inc
    .vmk4/gss3/pages/agent.inc
    .vmk4/gss3/pages/catalog.inc
    .vmk4/gss3/pages/contacts.inc
    .vmk4/gss3/pages/docs.inc
    .vmk4/gss3/pages/index.inc
    .vmk4/gss3/pages/service.inc

Project handler: `.vmk4/gss3/router/mod.php`.
`pages/.map.inc` отсутствует.

## Известные blockers

- `.vmk4/site/web/web[self].inc` ожидает отсутствующий local `web/web.php`;
- `.vmk4/gss3/iq.inc` передаёт absolute path как `dirSelf`;
- project CSS pattern `css/%sid-css.php` не раскрывается current `iqPro`;
- router path/ctx contracts имеют известные расхождения;
- snapshot не содержит собственные `r/rb` и `r/lay`;
- product/catalog JSON не читались, settings/credentials не переносились.

Использовать project только как structural reference. Перед переносом в
`wm-0` исправить bootstrap/contracts отдельной задачей и выполнить smoke suite.
