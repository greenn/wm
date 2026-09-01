# Routing страниц

Pages v2 — каноническая server-модель нового проекта. URI разрешается в PID,
page data и handler до начала client-side приложения.

## Current request flow

```text
GET /catalog/item
  -> project .htaccess
  -> site/router.php
  -> project iq.inc
  -> site_router::applyHandlerByUri()
  -> page_uri
  -> pages/<pid>.inc
  -> rb_router2
  -> page/page + page/html
```

Пустой URI становится `base_pid`, обычно `index`. Сначала проверяется точный
page file. Если его нет, router отбрасывает сегменты справа и принимает
ближайшего parent только при `is-mod=true`; остаток становится `subUri`.

## Выбор handler

Page property `router` задаёт явный handler, `router-ctx` дополняет context,
`redirect` выбирает redirect handler. Иначе пробуется handler с именем PID,
затем `site` для существующей страницы или `http-404` для неизвестной.

`.map.inc` задуман как URI/PID map, но current входной flow не гарантирует
полное разрешение alias и содержит debug-разрыв. До отдельного fix и tests
карта не считается готовым public routing contract.

## PHP-router и Vue Router

PHP отвечает за page shell, bootstrap, status и права. `vue-router` отвечает
за transitions/back/forward внутри shell. History mode требует Apache fallback
для direct URL и reload; hash fragment PHP-сервер не получает.

## Обязательные HTTP-проверки

- известная page возвращает 200;
- unknown URI возвращает настоящий 404;
- redirect имеет ожидаемый 3xx и безопасный `Location`;
- static file не попадает в page router;
- nested `is-mod` получает корректный `subUri`;
- Vue history direct URL возвращает ту же shell;
- error не раскрывает paths, settings, SQL и tokens.

> [!UNRESOLVED]
> Current snapshot содержит `router/router`, `routerFile/fileRouter`, 404 status
> и project handler context gaps. Они документированы, но не исправляются
> неявно при добавлении страницы.
