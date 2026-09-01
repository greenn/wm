# Pages legacy

Статус: **только совместимость и миграция**. Для нового кода использовать
[pages-v2.md](pages-v2.md), Vue 3 и current project environments.

## Где лежат старые реализации

| Слой | Legacy path/symbol |
|---|---|
| Page data manager | `web/php/site/v1/_page.class.php`, class `_page` |
| Page object | `web/php/site/v1/page.class.php`, class `page` |
| URI/PID parser | `web/php/site/v1/pid.class.php`, class `pid` |
| Server router | `web/php/site/v1/_router.class.php`, class `_router` |
| Handler runner/context | `r/rb/router/router.class.inc`, class `rb_router` |
| Base handlers | `web/php/site/v1/router/*.php` |
| Typical page data | `.blank/iq/config/pages/<pid>.inc` |
| URI/PID map | `.blank/iq/config/pages.inc` |
| Project handler override | `.blank/iq/config/router/<handler>.php` |
| Project base handlers | `.blank/iq/router/*.php` |
| Transitional overlay | `.gss1/gss3/iq/pages` и `.gss1/gss3/iq/router` |

Dot-project paths — примеры, не канон. В snapshot `.blank` также не содержит
ожидаемые `iq/php/iq.class.php` и `iq/router.php`, хотя `.blank/index.php` и
root `.htaccess` на них ссылаются. Поэтому `.blank` нельзя считать runnable
blank до отдельного ремонта.

## Legacy request flow

Задуманная цепочка старого проекта:

```text
URL
  -> root .htaccess -> iq/router.php
     либо DirectoryIndex index.php -> pro('proDir').'/router.php'
  -> _router::applyHandlerByUri()
  -> _pid::create()/pid
  -> _page data из iq/config/pages
  -> project iq/config/router override или iq/router base handler
  -> rb_router::processPath()
  -> site templates
```

`_page::pidFilePath()` использует `pro('configDir').'/pages'`; hook
`hkIqPages` может заменить каталог. `pages.inc` служит URI/PID map.
`_router::handlerPath()` сначала ищет project override в
`pro('configDir').'/router'` (либо `hkIqRouter`), затем base handler в
`pro('proDir').'/router`.

Handler выбирается из page `router`; `router-ctx` добавляется к context,
`redirect` переключает на redirect handler. Без явного handler пробуется имя
PID, затем `site` для найденной страницы либо `http-404` для неизвестной.
`pid` поддерживает parent module через `is-mod` и передаёт хвост URI в
`subParts`/`subUri`.

## Отличия v1 от v2

| Legacy v1 | Current v2 |
|---|---|
| Глобальные `_page`, `page`, `pid`, `_router` | Project-aware `_pages`, `site_page`, `page_uri`, `site_router` |
| `iq/config/pages/<pid>.inc` | `<project>/pages/<pid>.inc` |
| `iq/config/pages.inc` | `<project>/pages/.map.inc` |
| `iq/config/router` override, `iq/router` base | `<project>/router` + `web/php/site/v2/router` |
| `rb_router` | `rb_router2` |
| Main RM через `site`/hooks | Main RM через project option `rMain` |
| Vue 2 встречается в старых приложениях | Vue 3 — default для нового кода |

Названия полей (`title`, `seo`, `page-ctx`, `html-ctx`, `app-ctx`, `content`,
`content-tpl`, `router`, `router-ctx`, `redirect`, `is-mod`) похожи, но это не
делает реализации взаимозаменяемыми. При миграции проверять current consumer
каждого поля.

## Что не переносить автоматически

- bootstrap и absolute paths старого проекта;
- hooks `hkIqPages`, `hkIqRouter`, `hkIqMainR` без явной необходимости;
- Vue 2 router/components;
- старые `kot`, `ap`, `admin2` layouts как новый default;
- debug `dx()` и допущение, что отрисованная 404-страница уже имеет status 404;
- settings, credentials, product JSON и data из dot-projects.

## Порядок миграции одной страницы

1. Зафиксировать старый public URI, PID, page data и фактический handler.
2. Создать `<project>/pages/<pid>.inc` и подтвердить поля по v2 consumers.
3. Если URI динамический, проверить `is-mod`, `subUri` и project handler на
   `rb_router2`; не переносить старый `Pid` context вслепую — v2 передаёт `Uri`.
4. Перенести template/RM dependencies через current connectors.
5. Явно настроить canonical/redirect, status 404 и server auth.
6. Проверить direct URL, reload, query, nested URI, static files и Vue history.
7. Удалять legacy path только после сравнения response/status и approval в
   рамках поставленной задачи.
