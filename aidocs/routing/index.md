# Routing: карта входных точек

Этот раздел описывает HTTP-routing WM по фактическому snapshot. Здесь всегда
разделяются четыре статуса:

- **канон** — решение владельца для нового кода;
- **current** — подтверждённое поведение текущих файлов;
- **legacy/example** — материал только для совместимости или анализа;
- **gap** — цепочка выглядит задуманной, но в snapshot имеет разрыв и не должна
  копироваться без исправления и smoke test.

## Что читать

| Задача | Документ |
|---|---|
| Новые server pages и PHP-router | [pages-v2.md](pages-v2.md) |
| Старые `iq/config/pages` и `_router` | [pages-legacy.md](pages-legacy.md) |
| Root API и RM endpoint | [api.md](api.md) |
| Apache rewrite и защита каталогов | [htaccess.md](htaccess.md) |
| Физический `/admin/index.php` и Vue history | [admin.md](admin.md) |

## Основные цепочки

### Site page — каноническое направление v2

```text
GET /catalog/item
  -> project root .htaccess
  -> site/router.php
  -> <DOCUMENT_ROOT>/iq.inc -> project/site IQ
  -> site_router::applyHandlerByUri()
  -> page_uri + <project>/pages/*.inc
  -> handler через rb_router2
  -> <rMain>/page/{page,html} templates
```

Для `/` Apache обычно открывает физический `index.php` через `DirectoryIndex`.
Этот файл должен загрузить project IQ и включить именно `cur('routerFile')`.
WM root сам по себе не является готовым сайтом: в корне репозитория нет
`index.php`, `iq.inc` и root `.htaccess`; эти точки принадлежат проекту.

### Root API

```text
METHOD /api/<rm-env>/<component>/<route>
  -> api/.htaccess -> api/index.php
  -> <DOCUMENT_ROOT>/iq.inc
  -> rt_api::response()/request()
  -> _<rm-env>::req(<component>)
  -> <rm-root>/<component>/api/<route>.<method>.inc
     fallback: <rm-root>/<component>/api/<route>.inc
  -> JSON
```

Current allow-list и пример `.vmk4/gss3` не согласованы; подробности и
безопасный порядок исправления — в [api.md](api.md).

### Admin

```text
GET /admin[/client-route]
  -> корневые правила пропускают физический /admin
  -> admin/.htaccess -> admin/index.php
  -> PHP bootstrap/auth/ACL
  -> Vue 3 app; vue-router управляет только клиентской историей
```

Физическая точка `/admin/index.php` — канон. Rewrite `.vmk4` на отсутствующий
`/ap/router.php` — gap, а не альтернативный default.

## PHP-router и vue-router

PHP-router определяет server page, выполняет bootstrap/auth и отдаёт initial
HTML при первом открытии и reload. `vue-router` решает переходы внутри уже
загруженного Vue 3 приложения. Для history mode каждый client URL обязан иметь
server fallback в правильный PHP entry point; hash mode в таком fallback не
нуждается, потому что fragment не отправляется серверу.

## Проверка перед изменением routing

1. Найти реальный document root проекта, `index.php`, `iq.inc` и root
   `.htaccess`; не подставлять `.vmk4` как готовый blank.
2. Проследить один URL до конечного handler/endpoint, включая все per-directory
   `.htaccess`.
3. Проверить прямой URL, reload, query string, существующий static file,
   неизвестный URL и URL с завершающим `/`.
4. Проверить реальные HTTP status, `Location`, `Content-Type`, CORS и отсутствие
   внутренних paths/debug в ответе.
5. Для admin/API проверить server-side authentication и authorization; Vue
   guards, `v-if` и скрытые кнопки защитой не являются.
6. Глобальный rewrite вне прямого задания сначала оформлять как proposal в
   `man/sug` и выполнять только после approval владельца.
