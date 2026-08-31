# Pages v2 и server router

## Каноническая модель

Для нового проекта page data находятся в:

    <project>/pages/<pid>.inc
    <project>/pages/.map.inc      # необязательная карта URI <-> PID

Основные current-сущности: `_pages`, `site_page`, `page_uri`,
`site_router` и `rb_router2`.

## Разрешение запроса

1. Пустой URI заменяется project `base_pid`.
2. `.map.inc`, если существует, сопоставляет URI и PID.
3. Проверяется точный `<pid>.inc`.
4. Если точной страницы нет, `page_uri` отбрасывает хвост URI и ищет самый
   подходящий parent с `is-mod`; остаток становится sub-URI.
5. Page data может задать `router`, `router-ctx` или `redirect`.
6. Без явного router сначала проверяется handler с именем PID, затем current
   default `site` либо `http-404`.
7. Handler запускается через `rb_router2`; page shell/templates выбираются
   через project `rMain`.

Page file может содержать title/SEO/link, `page-ctx`, `html-ctx`,
`app-ctx`, content/template, redirect и `is-mod`. Точные поля подтверждаются
по current consumers.

## PHP-router и vue-router

PHP-router всегда определяет server page и initial HTML. `vue-router`
используется внутри Vue 3 приложения, каталога или корзины для переходов и
истории. Для любого client route должны быть определены reload/direct-link
поведение и server fallback.

## Известный implementation gap

Current `site_router::handlerPath()` добавляет `/router/<handler>.php` к
`routerDir`, тогда как default `iqPro` уже инициализирует `routerDir` как
`<project>/router`; это способно дать двойной `router/router`. В
`.vmk4/gss3` также есть несовпадения `Pid`/`Uri`, `r-class` и sitemap.
Не копировать этот пример как рабочий blank до отдельного исправления и smoke
test.

Legacy page systems из `iq/config/pages`, `iq/pages` и старых routers
документируются отдельно, но не используются для нового проекта.
