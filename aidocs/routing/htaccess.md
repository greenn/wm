# `.htaccess`: rewrite chains WM

Snapshot содержит 48 `.htaccess` вне запрещённых зон. Корень WM не имеет
собственного `.htaccess`: root rules принадлежат project templates/examples.
Ни один dot-project ниже не является каноном нового проекта.

## Как читать правила

- `RewriteCond 1 1` — секция фактически включена; `RewriteCond 1 10` и
  `RewriteCond 1 0` — выключена.
- В per-directory `.htaccess` pattern `RewriteRule` видит path без ведущего `/`.
- Подстановка без `?` сохраняет исходный query string; `[QSA]` нужен, когда к
  подстановке добавляется собственный query и надо объединить его с исходным.
- Порядок правил важен. `[L]` завершает текущий rewrite pass, но internal
  rewrite может начать новый pass; всегда проверять loop.
- Условия `!-f`/`!-d` означают: реальный public file/directory проходит мимо
  site fallback. Они не защищают include/settings сами по себе.
- `RewriteRule ^ - [F,L]` возвращает 403 и применяется как directory data gate.

## Каноническая project root chain

Для нового проекта целевая форма такая:

```text
existing public file/dir -> Apache directly
/api/...                 -> physical /api -> api/.htaccess -> api/index.php
/admin[/...]             -> physical /admin -> admin/.htaccess -> admin/index.php
ordinary site URI        -> site/router.php -> site_router
```

Special routes `favicon.ico`, `robots.txt`, `sitemap.xml`, `test` и
`site/static` добавляются только если их target существует и маршрут нужен
проекту. Settings, `.inc`, dotfiles, backups, source maps с secrets и private
data должны быть закрыты server config/root rules; разрозненных data gates
недостаточно.

`test` публикуется только в согласованной dev-среде. HTTPS redirect учитывает
реальную proxy scheme (`X-Forwarded-Proto`) только от trusted proxy, иначе
возможен loop или spoofing.

## `.vmk4/.htaccess`: current v2-shaped example

Секции идут в таком порядке:

1. UTF-8, `RewriteEngine on`, `RewriteBase /`.
2. Выключенный (`1 10`) debug rewrite в `iq/url/htaccess.php`.
3. Выключенный HTTPS redirect для одного host.
4. Включённый favicon -> `gss3/i/favicon/1/favicon.ico`.
5. `robots.txt` -> `site/url/robots.txt.php`.
6. `sitemap.xml` -> `site/url/sitemap.xml.php`.
7. Выключенный `/test/*` alias.
8. Если исходный URL не file, но `site/static/<URI>` существует, rewrite в
   `/site/static/<URI>`.
9. Любой `/admin...` rewrite в `/ap/router.php`.
10. Любой оставшийся non-file/non-directory URI -> `site/router.php`.

Примеры цепочек:

```text
GET /catalog/x
  -> .vmk4/.htaccess rule 10
  -> .vmk4/site/router.php
  -> .vmk4/iq.inc -> .vmk4/gss3/iq.inc
  -> site_router

GET /api/site/menu/list
  -> /api — physical directory, root fallback его пропускает
  -> .vmk4/api/.htaccess
  -> .vmk4/api/index.php -> rt_api

GET /admin/x
  -> rule 9 -> /ap/router.php
  -> gap: `.vmk4/ap` отсутствует
```

Последняя admin-цепочка противоречит канону `/admin/index.php`. Правило ловит
и физический `/admin`, потому что стоит до `!-d`; не переносить его. Файлы
`.vmk4 — копия/.htaccess` и `.vmk4 — копия/api/.htaccess` повторяют ту же форму
и также являются только примером.

Child front controllers `.vmk4/api/.htaccess` и `.vmk4/wd/.htaccess`
переписывают любой непустой relative path соответственно в локальный
`index.php`; первый ведёт в root API, второй — в project WD. Data gate
`.vmk4/gss3/r/menu/data/.htaccess` отвечает 403. Это targeted project coverage,
а не разрешение копировать `.vmk4` целиком.

## Committed framework front controllers

| Path | Фактический смысл |
|---|---|
| `api/.htaccess` | Любой непустой relative path -> `index.php`; root API entry. Нет `[L]` и явного исключения `index.php`, поэтому loop/direct-index поведение проверять на реальном Apache. |
| `admin/.htaccess` | Любой непустой relative path -> `index.php`; server fallback для `/admin/*`. Также перехватывает relative asset paths. |
| `wd/.htaccess` | Любой непустой relative path -> `index.php`; front controller инструмента WD. |
| `r/rb/system-/api/.htaccess` | Любой непустой relative path -> локальный `index.php`; внутренний/dev system API, не public default. |
| `r/rb/vue/test/app/7/.htaccess` | Test SPA fallback -> `index.php`; только тестовый пример. |
| `kot/.htaccess` | Всё, кроме `/kot/test`, `/kot/iq`, `/kot/r`, `/kot/img`, -> `index.php`; legacy app shell. |
| `kot/r-test/.htaccess` | Всё, кроме собственного `index.php`, -> `/kot/r-test/index.php`; test front controller. |

Root `api/admin/wd` rules не имеют `!-f/-d`: static под этими directories может
быть переписан. Current apps в основном используют absolute assets снаружи,
но это требуется проверить перед добавлением relative asset.

## Committed blank templates

### `.blank/.htaccess` — legacy v1 skeleton

Debug, HTTPS, favicon/robots/sitemap в основном выключены. Включён `/test/*`
alias при существующем target file, затем non-file/non-directory fallback в
`iq/router.php`. В snapshot этот target отсутствует; template не runnable.
`.blank/r/site/menu/data/.htaccess` — data gate 403.

### `.blank2/.htaccess` — transitional v2 skeleton

UTF-8; favicon и robots включены; sitemap выключен; `/test/*` при существующем
`test-gss` file; остаток non-file/non-directory -> `site/router.php`. Child
files:

- `.blank2/api/.htaccess` -> `api/index.php`;
- `.blank2/wd/.htaccess` -> `wd/index.php`;
- `.blank2/r/rb/system-/api/.htaccess` -> local `index.php`;
- `.blank2/r/rb/vue/test/app/7/.htaccess` -> test `index.php`.

`.blank2` исправляет в `index.php` имя `routerFile`, но не содержит ожидаемый
`gss3`; это structural template для будущего ремонта, не готовый project.

## Dot-project и legacy examples

Все перечисленные files проанализированы только по rewrite-смыслу:

| Paths | Смысл и ограничение |
|---|---|
| `.ash/.htaccess` | Legacy `iq/router.php` fallback; включён host-specific HTTPS и robots. Не переносить host. |
| `.ash/mafia-project/.htaccess` | `/card/0..15` -> PNG, затем безусловный `iq/router.php`; project-specific static alias. |
| `.ash/novgorod-project/.htaccess` | Набор project-specific image aliases, затем безусловный `iq/router.php`. |
| `.gss1/.htaccess` | Transitional root: favicon/robots, sitemap off, test alias, legacy `iq/router.php`. |
| `.kp/.htaccess`, `.tosno/.htaccess`, `.zo/.htaccess` | Legacy site roots: special files/test и fallback `iq/router.php`; host/config различаются. |
| `.kp/admin/.htaccess`, `.tosno/admin/.htaccess`, `.zo/admin/.htaccess` | Legacy admin SPA/front controller -> `index.php`; это подтверждает форму, но не архитектурный default проекта. |
| `.ripr/ripr/.htaccess` | Front controller -> `index.php`, кроме `/ripr/r` и `/ripr/i`; legacy app overlay. |

### Private data gates в examples

Одинаковый 403 pattern находится в:

- `.gss1/gss3/r/menu/data/.htaccess`,
  `.gss1/r/site/{catalog,menu}/data/.htaccess`;
- `.kp/r/site/menu/data/.htaccess`;
- `.tosno/r/site/{catalog,menu}/data/.htaccess`,
  `.tosno/r/site1/{catalog,menu}/data/.htaccess`,
  `.tosno/r/site2/{catalog-2,catalog-3,catalog,company,posts,service}/data/.htaccess`,
  `.tosno/r/site2/user/_db/.htaccess`;
- `.vmk4/gss3/r/menu/data/.htaccess`;
- `.zo/r/site/menu/data/.htaccess`, `.zo/r/site1/menu/data/.htaccess`.

Эти gates полезны как defense-in-depth, но Apache должен разрешать override в
этих каталогах. Надёжнее дополнительно не размещать private data под public
document root и закрыть общий class служебных extensions/paths.

## Риски, которые проверять явно

- Порядок `/admin` относительно physical-directory pass-through.
- DirectoryIndex для пустых `/`, `/api/`, `/admin/`; pattern `.` не ловит
  пустой relative path.
- Internal rewrite loop для `RewriteRule . index.php` и direct `index.php`.
- Сохранение query string, encoded URI, double slash, trailing slash и case.
- Static route target действительно существует и не раскрывает private file.
- Не выдаются `.inc`, settings, `.env`, backup (`~`, `.bak`, `.old`), VCS и
  dotfiles.
- Реальные statuses: forbidden 403, unknown 404, method 405, maintenance 503.
- Proxy-aware HTTPS без redirect loop.

## Минимальная HTTP-матрица после изменения

Проверить на целевом Apache/vhost, не только чтением regex:

| Request | Ожидание |
|---|---|
| `/` | project `index.php`, 200 |
| известная server page | `site/router.php`, 200 |
| неизвестная page | server 404 + 404 shell |
| существующий CSS/image | файл, не PHP-router |
| `/api/<allowed>/...` | `api/index.php`, корректный JSON/status |
| `/api/<unknown>/...` | ранний 404/403, без dynamic manager call |
| `/admin` и deep admin URL | `admin/index.php`; auth/ACL |
| private `.inc`/settings/data | 403/404 |
| dev `/test/...` в production | недоступен |

Глобальное изменение rewrite вне прямого задания оформляется в `man/sug` и
ждёт approval владельца.
