# Bootstrap, web и IQ

Status: **current** для active root chain; centralized owner contract частично
**unresolved**.

## Фактическая root-цепочка

1. Entry project/site включает `iq.inc`.
2. `site/iq.inc` подключает `site/php/_webConnector.class.php`.
3. `connect_web()` создаёт `_webConnector`, определяет host/subdomain.
4. `_webConnector::connect_web()` сначала ищет
   `site/web/web[self].inc`, затем `site/web/web[<host>].inc`.
5. Connector включает реальный `web/web.php`.
6. `web/web.php` определяет `ROOT`, `WEB`, `PHP`, `LIB`, `INC` и
   подключает `web/php/need.php`.
7. `connect_web_req()` загружает v2 IQ, pages, source, image/CSS и RM managers.
8. `site/iq.inc` вызывает `_iq::add_site('gss', ...)`.
9. Constructor `iqSite` читает common и host settings, domains, router и
   подключает `site/uv/<sid>[<host>].uv`.
10. Project `iq.inc` регистрирует `iqPro` через `_iq::add_pro(...)`.

## Local web

`site/web/web[self].inc` строит
`<DOCUMENT_ROOT>/web/web.php`. Режим работает только при реально существующем
local `web`.

## Centralized web: решение и gap

Владелец задаёт centralized mode через
`site/settings/settings[<domain>].inc`, чтобы project использовал общий web
без копии. В active root implementation web подключается до создания
`iqSite` и до чтения settings. Следовательно, settings пока не могут сами
выбрать первоначальный `web/web.php` без дополнительного pre-bootstrap
connector contract.

До исправления:

- документировать owner target и current chain отдельно;
- не утверждать, что settings уже подключают shared web;
- не угадывать путь;
- для каждого project проверять фактически выбранный self/host connector.

## IQ public accessors

```php
<?
$Site = site();
$host = site('hostName');
$Project = pro();
$pagesDir = pro('pagesDir');
$value = cur('property');
```

`site()`/`_site()` вызывают `iqSite`; `pro()`/`_pro()` —
`iqPro`. `cur()` сначала смотрит current project, затем current site.

## iqPro contract и gaps

- Абсолютный project root — `selfDir`; относительный от `DOCUMENT_ROOT` —
  `dirSelf`.
- Default paths: `php/<sid>.env.php`, `css/<sid>-css.php`, `wd`,
  `pages`, `router`.
- Env handlers дают `css()`, `i()` и project-specific calls.
- В current `iqPro::$directAssignProps` дважды указан `selfDir`; `dirSelf`
  не назначается напрямую.
- Literal `css/%sid-css.php` не интерполируется; нужен `css=true` либо
  конкретный path.

Перед новым project выполнить bootstrap smoke test и сверить вычисленные
`selfDir`, `pagesDir`, `routerDir`, `wdDir`, `rMain`.
