# Pages v2 и server router

Статус: **канон для нового проекта**, но current implementation имеет
перечисленные ниже gaps. Не копировать `.vmk4/gss3` как готовый рабочий blank.

## Контракт проекта

```text
<project>/
  iq.inc
  pages/
    <pid>.inc
    .map.inc          # optional URI/PID map
  router/
    <handler>.php     # optional project handlers
  r/
    <component>/...
```

`iqPro::$pagesDir` и `iqPro::$routerDir` задаются в
`web/php/site/v2/iq/iq-pro.class.php`. Project environment регистрирует класс
pages; фактический пример — `pages_gss3 extends _pages` в
`.vmk4/gss3/php/gss3.env.php`. Главные current symbols:

- `_pages` — `web/php/site/v2/_pages.class.php`;
- `site_page` — `web/php/site/v2/site_page.class.php`;
- `page_uri` — `web/php/site/v2/page_uri.class.php`;
- `site_router` — `web/php/site/v2/site_router.class.php`;
- `rb_router2` — `r/rb/router2/router2.class.inc`;
- helpers `_pageData()`, `pro_page()`, `_pageFor()` —
  `web/php/site/v2/iq/iq-page.php`.

Минимальный page file использует обязательные для нового PHP короткие теги:

```php
<?
return array(
    'title' => array('page' => 'Контакты'),
    'content-tpl' => array('contacts', 'content-contacts'),
);
```

## Current request flow

1. Project root rewrite отправляет несуществующий site URI в
   `site/router.php`. Current support file — `site/router.php`; project copy
   должен включать `<DOCUMENT_ROOT>/iq.inc`.
2. `site_router::applyHandlerByUri()` получает framework constant `pageUri`.
3. `site_router::resolveUri()` заменяет пустой URI на `base_pid`, проверяет
   canonical map/redirect и `overlap`.
4. `site_router::page_uri()` делает `urldecode()`, приводит URI к lower case и
   создаёт `page_uri`.
5. `page_uri` сначала проверяет точный `<pagesDir>/<uri>.inc`. Если его нет,
   отбрасывает сегменты справа и принимает ближайшего parent только при
   `is-mod=true`; остаток попадает в `subParts`/`subUri`.
6. Router сохраняет current URI через `cur('pages', 'curUriSet', $Uri)` и
   формирует context `array('use-pid' => $pid, 'Uri' => $Uri)`.
7. `resolveHandlerNameByPid()` применяет page `router`, `router-ctx` и
   `redirect`; иначе пробует handler с именем PID. Fallback: `site` для
   существующей страницы, `http-404` — для неизвестной.
8. `site_router::applyHandler()` загружает RM `router2`, а
   `rb_router2::processPath()` исполняет handler как template с context.
9. Base handler `web/php/site/v2/router/site.php` вызывает
   `rb_router2::prepareRootCtx()`, затем рендерит templates `page/page` и
   `page/html` через `_r_tpl_($rMain, ...)`, где `rMain=cur_opt('rMain')`.

## Page fields, подтверждённые consumers

| Поле | Consumer и эффект |
|---|---|
| `title.page-raw`, `title.page`, `title.content` | `rb_router2::handlePageTitle()` и `handleContentTitle()` |
| `seo` | переносится в `html-ctx.seo`; `sitemap=false` добавляет `norobots` |
| `og` | `rb_router2::handlePageOg()` дополняет URL/title/description/image/type при включённом project OG |
| `page-ctx` | context template `page/page` |
| `html-ctx` | context outer template `page/html` |
| `app-ctx` | передаётся outer template как `app` |
| `content-tpl` | переносится в page context |
| `content` | string становится `page-ctx.content`; array расширяет page context |
| `contents` | переносится в `page-ctx.contents` |
| `router` | имя server handler для PID |
| `router-ctx` | дополняет handler context |
| `redirect` | URI либо array `[URI, code]`; `true` во второй позиции означает 301, default handler code — 302 |
| `is-mod` | разрешает parent page обслуживать остаток URI |
| `overlap`, `overlap-opt` | current механизм подмены PID в `site_router::verifyHandlerOverlap()` |
| `link.*` | `site_page::linkCfg()`, `uri()`, `link()`; поддержаны external/url/protocol/subDomain/domain/uri/subUri |
| `page-tpl`, `header` | читаются handler `web/php/site/v2/router/plain.php`; перед применением проверить этот legacy-shaped handler отдельно |

Не добавлять поле по аналогии со старым проектом, пока нет current consumer.

## `.map.inc`: намерение и фактический gap

`_pages::getUriMap()` читает `<pagesDir>/.map.inc`, а `getUriPid()` умеет прямое
и обратное сопоставление. Current consumers используют карту для link/canonical
операций и внутри mod resolution. Однако `page_uri::__construct()` не переводит
входной точный URI через `getUriPid()` перед `hasPid()`. Кроме того,
`site_router::verifyHandlerRedirectByUri()` содержит debug `dx()` на mapped
alias, а `autoRedirectToRelUri` выключен.

Следствие: не обещать, что `.map.inc` уже надёжно маршрутизирует любой alias.
Это надо закрыть отдельным fix + tests: alias, canonical URI, reverse link,
query string и redirect loop.

## PHP-router против vue-router

- PHP-router остаётся владельцем server page и initial HTML.
- Vue 3 + `vue-router` допустим внутри приложения, каталога или корзины для
  back/forward и client transitions.
- `r/rb/vue/env-js/vue-root/router.js.inc` выбирает hash history по умолчанию;
  `routerOpt.nohashRouter=true` включает `createWebHistory(base)`.
- Для history mode Apache должен вернуть тот же PHP shell при прямом URL и
  reload. Server при этом всё равно должен понимать, какую оболочку/страницу
  отдать; API и права остаются server-side.
- Не заводить два независимых источника истины для одного URL: явно определить
  server shell, client base и fallback.

## 404, redirect и безопасность

- Неизвестный URI обязан отвечать реальным HTTP 404, а не только HTML страницы
  `404`.
- Redirect URI должен быть допустимым local path либо явно разрешённым host;
  code ограничивается согласованными 3xx. Нельзя передавать непроверенный input
  прямо в `Location`.
- URI/PID/handler нельзя использовать для обхода directory boundaries;
  проверять нормализацию, encoded separators и `..`.
- Page content и contexts не дают authorization: доступ проверяется в PHP
  handler/API до render.
- Ошибка не раскрывает absolute paths, settings, SQL и tokens.

## Current implementation gaps

1. `site_router::handlerPath()` строит user path как
   `pro('routerDir')."/router/$handler.php"`, хотя default `routerDir` уже равен
   `<project>/router`; возможен `router/router`.
2. Current `site/router.php` передаёт три аргумента в двухаргументный
   `applyHandlerByUri()`; лишний аргумент не является документированным
   контрактом.
3. `web/php/site/v2/router/http-404.php` не устанавливает
   `http_response_code(404)` и делегирует через legacy `rb_router`, а не
   `rb_router2`.
4. Redirect handler принимает URI/code без собственной валидации.
5. `.vmk4/index.php` запрашивает `cur('fileRouter')`, но `iqSite` предоставляет
   `routerFile`; `.blank2/index.php` показывает правильное имя, но сама
   `.blank2` также не является готовым проектом.
6. `.vmk4/gss3/router/mod.php` ожидает `Pid` и `r-class`, тогда как current v2
   context передаёт `Uri`, а page `catalog.inc` не задаёт `r-class`.
7. `.vmk4/gss3` не имеет `.map.inc`; sitemap и реальные page files расходятся.

## Smoke checks после целевого исправления

- `/` выбирает `base_pid` и возвращает 200.
- Известный PID, mapped alias и nested `is-mod` URI выбирают ожидаемые handler
  и context.
- Неизвестный URI возвращает status 404 и page shell без debug.
- Redirect возвращает ожидаемый 3xx/Location без open redirect и loop.
- Static file не попадает в PHP-router.
- Vue history: переход, back/forward, direct URL и reload дают один результат.
- PHP lint запускается с PHP 7.2 и `short_open_tag=On`.
