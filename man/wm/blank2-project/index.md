# blank2.wm: первый полный проект v2

Этап `=5` выполнен в указанном владельцем каталоге
`C:\S17\OpenServer\domains\blank2.wm`. Открывайте `http://blank2.wm/` при
запущенном OpenServer. Общий web подключается из
`C:\S17\OpenServer\domains\20.web\web`; копии web и man внутри проекта нет.

## Что можно открыть

| Адрес | Что проверяет |
|---|---|
| `/` | Стартовая server page, project RM и layout из lay. |
| `/about` | Обычная страница через PHP-router. |
| `/app` | Vue 3 с запросом к настоящему PHP API. |
| `/app/details` | Вложенный client route и PHP fallback при прямом открытии. |
| `/missing-page` | Настоящий HTTP 404. |
| `/start` | Контролируемый redirect на `/about`. |
| `/test/` | JSON с 16 проверками окружения и contracts. |

На экране приложения нажмите «Подробности», затем используйте Назад/Вперёд
браузера и перезагрузите страницу. Во всех случаях сохраняется выбранный URL.
Кнопка «Проверить API» показывает загрузку и результат запроса.

## Файлы и роли

`iq.inc` подключает `site/iq.inc` и `blank-app/iq.inc`: это отдельные `iqSite`
и `iqPro`. `blank-app/pages` содержит страницы, `blank-app/router` — project
handlers, `blank-app/r` — компоненты `page`, `demo`, `status` с обязательными
connectors. Шаблоны вызываются через `blankAppTpl`, assets — через source manager.

Из `rb` используются router2 и robots-txt, из `lay` — flex. Это проверенные
копии конкретных ресурсов WM. Vue и Vue Router загружаются локально, без CDN,
npm или сборки. Старый `index.html` оставлен на месте; Apache выбирает `index.php`.

## Повторная проверка

```powershell
& 'C:/S17/OpenServer/domains/blank2.wm/test/smoke.ps1'
```

Набор проверяет pages, 404, redirect, API method/fallback, права, CSRF, JSON,
восстановление тестового счётчика, доступ к внутренним файлам и MIME всех assets.
На реальном Apache/PHP 7.2.34 прошли **46 HTTP/API проверок** и **16 runtime
contracts**. Новых сообщений в PHP error log полный прогон не добавил.

В браузере подтверждены mount, успешный API request, переход между экранами,
Назад/Вперёд и reload `/app/details`. Mount ожидает готовности DOM, потому что
source manager подключает скрипты в head. Desktop evidence:
`man/wm/blank2-project/desktop.png`.

## URL-версии

База хранится в `site/uv/blank2[blank2.wm].uv`. После изменения static assets:

```powershell
Invoke-RestMethod 'http://blank2.wm/test/update-uv.php' -Method Post -Headers @{'X-WM-Smoke'='1'}
```

Helper доступен только локально и обновляет фиксированные семь файлов через
native UV storage. Он считает content version без HTTP-запроса, поскольку cURL
в данном Apache PHP отключён. Runtime URL по-прежнему формирует `qv()`.

## Границы примера

API counter и `test/session.php` — disposable тесты auth/ACL/CSRF; это не готовая
учётная система сайта. Ни БД, ни реальные пользователи, ни credentials не нужны.
Project-local router fixes описаны в agent map; общий web остаётся неизменным.

Код живёт в реальном каталоге OpenServer вне Git WM. Этот WM-релиз хранит
документацию и свидетельства проверки. При остановленном OpenServer домен
недоступен: для работы нужен запуск настроенного сервера.

Далее: [контракты RM](doc:rm/index), [полная smoke matrix](doc:reference/testing),
[предыдущий isolated RM test](doc:wm/blank-rm).
