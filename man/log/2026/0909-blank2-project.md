# Этап =5: проект blank2.wm

Начало: 2026-09-08. Проверки и документация: 2026-09-09. Версия WM: 20.0.6.
Ветка WM: `astra-high`, после результата этапа =4 `9e87928`.

По прямому уточнению владельца вместо `J:\dv\wm-0` использован реальный root
`C:\S17\OpenServer\domains\blank2.wm`, shared web из соседнего `20.web/web`.
Работа выполнена в этом каталоге; original index.html не заменялся.

Реализованы IQ v2, named RM blankApp, pages/router, rb/lay consumers, Vue 3
history, API с method-specific/fallback dispatch, auth/ACL/CSRF test fixture,
static assets, UV content refresh, Apache access rules и root smoke scripts.

Проверено на настоящем Apache: 46 HTTP/API checks + 16 runtime contracts,
PHP 7.2 lint 44 файлов, node syntax checks. Vue mount, API loading/success,
client transition/back/forward/direct reload прошли браузерную проверку.
Скриншот desktop сохранён. Полный HTTP-прогон не добавил ошибок в PHP log.

Найденные в процессе ошибки исправлены локально: ранний Vue mount; отсутствие
WOFF2 MIME в Apache; static scope внутри API inc; отсутствие cURL при UV refresh.
Shared web и соседние проекты не менялись.

После внешнего прерывания Apache оказался остановлен и домен отсутствовал в
hosts. Временный 503 fixture восстановлен в оригинальный ping endpoint;
неподтверждённый результат error UI не объявляется PASS. Обязательные проверки
этапа уже пройдены; дополнительный error UI и mobile compare не подтверждены.
Для повторного открытия проекта требуется запустить OpenServer.

В Git WM входят документация и evidence; actual project source находится вне
этого репозитория. [Руководство проекта](doc:wm/blank2-project).
