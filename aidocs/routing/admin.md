# Admin routing

Каноническая физическая точка входа по умолчанию:

```text
/admin/index.php
```

Другой public path или rewrite допустим только как явно заданная архитектура
конкретного проекта. `kot`, `admin2`, `ap` и dot-project variants — legacy или
examples, не новый default.

## Current committed chain

Если project root пропускает физический каталог `/admin`, цепочка такая:

```text
GET /admin[/client-route]
  -> admin/.htaccess
  -> admin/index.php
  -> include <DOCUMENT_ROOT>/kot/iq.inc
  -> current isMe gate
  -> admin_tpl('app', 'html', array('baseUri' => '/admin'))
```

`admin/.htaccess` переписывает любой непустой relative path в `index.php`, что
может обслуживать Vue history URLs. Пустой `/admin/` зависит от DirectoryIndex.
Правило не исключает real files/directories, поэтому relative admin assets
тоже попадут в `index.php`; current shell должен использовать проверенные
absolute/static paths.

Текущий `admin/index.php` — legacy wrapper над `kot`, а проверка `isMe` с
ответом «Обновление…» не является production authentication/authorization.
Он подтверждает физическую точку входа, но не служит blank новой админки.

Загруженный `kot/iq/admin.class.php` действительно объявляет `_admin`,
`admin()`, `admin_tpl()` и `api_admin()`, но `_admin::rDir()` возвращает
`ROOT.'/r/admin'`. В committed WM этого каталога нет, поэтому локальный вызов
`admin_tpl('app', 'html', ...)` не имеет matching
`r/admin/app/app.class.inc`. `kot/r/app` принадлежит отдельному manager `_kot`
и не является неявным fallback. Полная resource-карта:
[resources/admin.md](../resources/admin.md).

## Известный конфликт `.vmk4`

`.vmk4/.htaccess` до проверки `!-d` ловит `/admin(?:/|$)` и отправляет request
в `/ap/router.php`. Каталог `.vmk4/ap` отсутствует. Поэтому фактическая
`.vmk4`-цепочка не доходит до `/admin/index.php` и является known gap.
`.vmk4 — копия` содержит тот же rewrite.

Нельзя «чинить» это копированием legacy `ap`: для нового проекта root rules
должны пропустить физический `/admin`, а его собственный `.htaccess` — вернуть
`admin/index.php` для client history.

## PHP-router и Vue Router

Ответственность PHP:

- bootstrap IQ/project environment;
- session/authentication;
- authorization/ACL для initial page и каждого API action;
- initial HTML, headers и status;
- fallback для direct URL/reload в history mode.

Ответственность Vue 3 + `vue-router`:

- client navigation и back/forward внутри загруженного app;
- отображение route component;
- UX guards, но не security boundary.

Framework helper `r/rb/vue/env-js/vue-root/router.js.inc` использует hash
history по умолчанию. `routerOpt.nohashRouter=true` переключает на
`VueRouter.createWebHistory(routerConfig.base)`; `baseUri` должен совпасть с
public mount, например `/admin`. Legacy `kot` apps используют no-hash/base
варианты как примеры.

Для history mode:

```text
browser GET /admin/users/42
  -> Apache -> /admin/index.php
  -> PHP auth + shell
  -> vue-router resolves /users/42 inside base /admin
```

Hash URL `/admin/#/users/42` не требует server rewrite fragment, но PHP всё
равно выполняет auth и отдаёт shell для `/admin/`.

## API boundary

Admin UI не получает прямой доступ к settings/credentials. Данные идут через
server endpoint с явным method, validation и ACL. Root API сейчас знает RM
prefix `admin`, но наличие строки в `$r_list` не доказывает, что project
bootstrap загрузил рабочий admin manager/component; перед публикацией route
проследить полный connector chain по [api.md](api.md).

Site RM может обращаться к БД напрямую либо к внутреннему admin API — это
архитектурный выбор проекта. Не создавать скрытый HTTP round-trip или общую
привилегию только ради повторного использования кода.

## Security requirements

- Guest получает 401/redirect по согласованному контракту; пользователь без
  права — 403. Проверка выполняется server-side.
- Каждый mutation endpoint повторно проверяет action-level permission.
- Client `v-if`, route guard, hidden menu и отсутствие ссылки не ограничивают
  доступ.
- Cookie/session mutation защищена от CSRF; session cookie имеет согласованные
  `Secure`, `HttpOnly`, `SameSite`.
- CORS не включается шире необходимого; credentials и wildcard origin не
  смешиваются.
- Errors не содержат SQL, paths, stack trace, settings или tokens.
- Login redirect проверяет target и не допускает open redirect.
- Static frontend bundle не содержит secrets и server settings.

## Preflight новой админки

1. Подтвердить document root и физический `admin/index.php`.
2. Проследить root `.htaccess` -> `admin/.htaccess` -> entry без `ap`/legacy
   hijack и rewrite loop.
3. Подтвердить IQ bootstrap, named RM, connector и API prefix.
4. Задать Vue Router base/history и catch-all component; history fallback не
   должен перехватывать API/static.
5. Реализовать server session/auth/ACL до UI routes.
6. Проверить `/admin`, deep direct URL, reload, back/forward, static asset,
   unknown client route и logout.
7. Проверить guest/user/admin, 401/403, CSRF, CORS и отсутствие secrets/debug.

Связанные документы: [routing index](index.md), [API](api.md),
[`.htaccess`](htaccess.md).
