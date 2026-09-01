# Устройство сайта

Сайт соединяет общее окружение `site`, прикладной project RM и page router.
Основная последовательность остаётся одинаковой для обычной страницы и
страницы с Vue-приложением.

```text
URL
  -> PHP-router
  -> page data
  -> handler
  -> RM/component templates
  -> HTML shell
  -> optional Vue 3 app
```

## Слои

`site/iq.inc` и `iqSite` определяют host, settings, server router и URL
versioning. Project environment, например `gss3`, определяет pages, handlers,
project RM, CSS и images.

Basic named RM `site` и project RM — разные сущности. Project-specific content
остаётся в `gss3`; повторно используемая site-оболочка должна принадлежать
отдельному current RM `site` после реализации его v2 manager.

## Как собрана страница

Page file возвращает data: title, SEO, content template, handler и contexts.
`site_router` выбирает handler, `router2` готовит context, после чего `rMain`
рендерит page shell и inner content.

Для текущего примера `rMain` должен указывать на project RM `gss3`, потому что
current v2 named RM `site` ещё не подтверждён.

## Client application

Vue 3 может управлять каталогом, корзиной или другим app-state. PHP-router всё
равно обязан вернуть правильную shell для первого запроса, прямого URL и
reload. Client guards не заменяют server authorization.
