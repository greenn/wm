# blank2.wm — результат этапа =5

Дата проверки: 2026-09-09. WM documentation checkpoint: `20.0.6`, ветка
`astra-high`. Это реализация `=5` по явному path override владельца.

## Расположение и ownership

- Project root: `C:/S17/OpenServer/domains/blank2.wm`.
- Реальный Apache virtual host: `http://blank2.wm/`, PHP 7.2.34, short tags On.
- Shared web: `C:/S17/OpenServer/domains/20.web/web`, версия `19.2.11`.
- Human docs: `J:/dv/wm/man/wm/blank2-project/index.md`.
- Project source находится вне Git WM; у project root нет своего Git repository.
  WM commit фиксирует документацию и контрольные суммы, а не копию deployment.
  [SHA-256 inventory](blank2-files.sha256) содержит относительные пути файлов
  этапа от project root; исходный `index.html` и runtime log исключены.
- Исходный `index.html` сохранён; `DirectoryIndex` выбирает новый `index.php`.
- Shared web, `.blank`, `.blank2` и dot-projects не изменены.

## Bootstrap и resource chain

```text
index.php -> iq.inc -> site/iq.inc
  -> site/php/web-connector.class.php (проверенная копия _webConnector)
  -> site/web/web[self].inc
  -> site/settings/settings[blank2.wm].inc -> заданный shared web/web.php
  -> iqSite(blank2), settings + site/uv/blank2[blank2.wm].uv
  -> blank-app/iq.inc -> iqPro(blank-app)
  -> blank-app/blank-app.env.inc
```

`ROOT` остаётся document root blank2.wm. Host settings читаются connector-ом
до Web и затем штатным `iqSite`; они содержат только созданные для примера
публичные значения и выбранный владельцем путь, без credentials.

`blankApp/_blankApp` — project RM, root `blank-app/r`. Компоненты `page`, `demo`,
`status` имеют точные connectors. `BlankPages extends _pages` обслуживает
`blank-app/pages`. Helpers `blankApp()` и `blankAppTpl()` используют `_r_/_r_tpl`.

В `r/rb` скопированы используемые `router2` и `robots-txt` (connector + close
template); в `r/lay` — `flex` (connector + 2-cols-grow-first template). Потребители:
server router, root smoke и стартовая страница. Неиспользуемые legacy/test/vendor
деревья RM не переносились. Vue 3.2.36, Vue Router 4.0.12 и Urbanist Bold взяты
из существующих локальных assets WM, без npm/build или внешнего CDN.

## Router и pages

`index.php` включает `site('routerFile')`. Site router validates URI, вызывает
`BlankRouter::applyHandlerByUri()` и использует существующие `page_uri`,
`site_router`, `rb_router2`, shared `router/site.php` и project page templates.

| URL | PID / результат |
|---|---|
| `/`, `/index.php` | `home`, 200 |
| `/about` | `about`, 200 |
| `/app`, `/app/details` | `app`, `is-mod=true`, project handler `app`, 200 |
| `/missing-page`, `/app/missing` | `404`, настоящий HTTP 404 |
| `/start` | 302, Location `/about` |

Project-local corrections известных shared gaps:

- `BlankRouter::handlerPath()` ищет `<routerDir>/<handler>.php`, без второго
  `router/`; shared router не меняется.
- Узкий `_page($pid, 'link')` bridge делегирует `pro_page($pid, 'uri')` для
  существующего вызова внутри `page_uri::mod_verify`; legacy IQ не загружается.
- `http-404.php` устанавливает status и вызывает v2 `rb_router2`, не legacy router.
- App handler получает `Uri`, разрешает только два client URL; redirect handler
  разрешает ровно `/about` и 302. `.map.inc` aliases не вводились.

## API

Root `api/index.php` валидирует RM/component/route/method до вызова скопированного
`rt_api::request()`. Разрешён только `blankApp/status`; root resolver сохраняет
приоритет `api/<route>.<method>.inc` перед `api/<route>.inc`.

- `GET /api/blankApp/status/ping`: public diagnostic, `ping.get.inc` имеет
  приоритет перед присутствующим `ping.inc`.
- `GET /api/blankApp/status/info`: generic fallback `info.inc`.
- `GET/POST/DELETE /api/blankApp/status/counter`: disposable session counter;
  guest 401, non-editor mutation 403, отсутствующий/неверный CSRF 403.
- POST принимает JSON, включая `charset`; invalid JSON 400, media type 415,
  amount вне integer 1–5: 422. DELETE возвращает тестовый counter к нулю.
- Неизвестный API 404, unsupported method 405. В ответ не попадают internal paths.

`test/session.php` выдаёт только локальную тестовую сессию: loopback + точный host
+ POST + `X-WM-Smoke: 1` + same-origin при наличии Origin. Roles reader/editor
не являются production auth. Cleanup уничтожает сессию; tokens не логируются.
Direct `.inc`, `.tpl.php`, settings/uv, test scripts и docs закрыты Apache.

## Assets, UV и browser

CSS/JS экспортируются source manager с `qv()`. Font/image URL также versioned;
Apache явно отдаёт WOFF2 как `font/woff2`. `page.css` и `page.js` принадлежат
component page; `demo/app.js` — Vue-приложению. Font-face использует тот же qv URL,
что preload. Vue mount ждёт и router.isReady(), и DOMContentLoaded.

В установленном Apache PHP отключён cURL. Поэтому `test/update-uv.php` обновляет
только фиксированный список семи static files: алгоритм `UV_CONTENT` общий
(`C` + adler32 контента без CR), запись через native `urlVersion::save()`.
Загрузка динамических или произвольных URL не поддерживается этим helper.
Это локальный POST с теми же host/header/loopback guards, не новая реализация qv.
`site/uv/blank2[blank2.wm].uv` — единственная project UV database.

## Проверка и продолжение

Из PowerShell 7:

```powershell
& 'C:/S17/OpenServer/domains/blank2.wm/test/smoke.ps1'
```

Подтверждены 46 HTTP/API assertions, 16 runtime contracts на `/test/`, lint
44 PHP/inc с PHP 7.2 и `short_open_tag=1`, синтаксис обоих новых JS. После полного
HTTP-прогона PHP error log не вырос. Browser: Vue mount после исправления,
API loading/success, переход на details, back, forward и reload details — PASS.
При изменении app.js и refresh UV checksum изменился с `C1c0d807e` на `Ca19ff2c0`,
браузер запросил новый ресурс. Desktop screenshot сохранён в human docs.

`test/runtime.php` даёт PHP/short-tags/mbstring без phpinfo. `site/runtime-error.log`
содержит историю локальной разработки и закрыт от HTTP. Старые cURL/mount-context
ошибки в истории не означают текущий failure; сравнивать время/прирост лога.

После остановки OpenServer домен перестаёт разрешаться; перед повторными HTTP
проверками запустить уже настроенный сервер. Временный API 503 fixture убран,
оригинальный `ping.get.inc` восстановлен. Результат проверки error UI после 503
не зафиксирован из-за прерывания и не объявляется PASS.

WD и MQR не используются: нет reference-макета или задачи на scaler. Новые
страницы проекта изменять в реальном project root по его `AGENTS.md`.
