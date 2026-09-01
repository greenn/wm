# Named RM admin

Status: canonical entry confirmed; committed implementation legacy/unresolved.

Подтверждённое решение владельца: canonical public/physical entry нового
проекта — `/admin/index.php`. Rewrite вида `/admin -> /ap/router.php`,
встречающийся в legacy projects, является project exception, а не default.

## Фактический committed manager

`admin/index.php` включает `kot/iq.inc`, который через legacy `iq` загружает
`kot/iq/admin.class.php`. Этот файл определяет:

```php
class admin extends rt
class _admin extends _rt
function admin($name, $method = null/*, ... */)
function admin_tpl($name, $tplName = true, $tplCtx = false,
                   $fileExt = 'tpl.php', $method = 'tpl')
function admin_vtpl($name, $tplName = true, $tplCtx = false,
                    $fileExt = 'tpl.php')
function api_admin($requestUri, $data = array())
class admin_api extends _api
class admin_i extends _img
```

`_admin::rDir()` возвращает `ROOT.'/r/admin'`, а `className($name)` —
`admin_<name>`. В committed WM каталог `r/admin` отсутствует, следовательно,
matching component connectors: **0**. В частности, вызов
`admin_tpl('app', 'html', ...)` из `admin/index.php` не имеет локального
connector `r/admin/app/app.class.inc`.

`kot/r/app` — другой named RM: `_kot::rDir()` указывает туда, helper называется
`kot()`, и найденные там 15 connectors нельзя выдавать за components `admin`.

## Граница нового admin

Current committed chain подтверждает форму entry и legacy contract, но не
готовый v2 admin RM. Перед реализацией:

1. определить project-owned root и v2 manager/base/helpers для `admin`;
2. создать только нужные components с matching `<component>.class.inc`;
3. заменить legacy `kot/iq.inc` bootstrap осознанной current v2 цепочкой;
4. реализовать server-side auth/ACL — Vue guards и скрытие controls не защита;
5. проверить `/admin/index.php`, `/admin/`, deep reload, assets, API и 404;
6. задокументировать rewrite как exception, если project его использует.

Не чинить отсутствующий `r/admin` копированием `kot/r/app` или legacy `ap`:
owner, namespaces, API и security contracts у них различаются.
