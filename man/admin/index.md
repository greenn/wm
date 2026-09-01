# Административное приложение

Каноническая физическая entry point нового проекта — `/admin/index.php`.
PHP выполняет bootstrap, authentication и authorization, затем отдаёт shell
Vue 3 приложения.

## Current committed состояние

Текущий `admin/index.php` подключает `kot/iq.inc`, проверяет legacy `isMe` и
вызывает `admin_tpl('app', 'html', ...)`. Это подтверждает форму public entry,
но не является blank новой админки.

`kot/iq/admin.class.php` объявляет manager `_admin` и helpers `admin()`,
`admin_tpl()`, `api_admin()`. Manager указывает на `ROOT.'/r/admin'`, которого
в committed WM нет. Matching components current root: **0**.

> [!UNRESOLVED]
> `kot/r/app` принадлежит отдельному manager `_kot` и не является fallback для
> `admin`. Копировать его components в новый admin без нового contract нельзя.

## Целевой состав

Новой админке нужны project-owned entry, v2 bootstrap, named RM manager,
matching component connectors, app shell, server API и tests. Каждый экран
документирует route, component/template, API endpoint и требуемое право.

Legacy `ap`, `admin2`, `kot` и admin из dot-projects остаются examples, а не
архитектурным default.
