# Known issues

Эти пункты подтверждены анализом, но не разрешены к попутному исправлению.
Полная исходная фиксация: `rule/ai/4 known-issues.md`.

## Bootstrap/IQ

- `.vmk4` active `web[self].inc` указывает на отсутствующий local web.
- Owner centralized mode через host settings расходится с active порядком:
  web подключается до `iqSite::connect_settings()`.
- `iqPro::$directAssignProps` не назначает `dirSelf`.
- `.vmk4/gss3` передаёт absolute path как `dirSelf`.
- Literal CSS path с `%sid` не интерполируется.

## Pages/resources

- `fileRouter`/`routerFile`, double `router/router`, `Pid`/`Uri` и
  missing `r-class` расходятся в observed project flow.
- Нет `pages/.map.inc`; sitemap и реальные pages не полностью совпадают.
- Есть ссылки на отсутствующие `seo`, `posts` и admin `ap`.
- Committed `admin/index.php` вызывает legacy `admin_tpl('app', ...)`, но
  `_admin::rDir()` указывает на отсутствующий `r/admin`; `kot/r/app` — другой
  named RM и не является fallback.
- Target named RM `site` подтверждён владельцем, но current v2
  manager/helper implementation не найден; `site()` занят IQ accessor.
- Shared web не перенаправляет `ROOT/r/rb` и `ROOT/r/lay` автоматически.

## Security

Excluded settings содержат plaintext credentials/tokens. Значения не
документировать, не копировать и не коммитить. Миграция secrets — отдельная
задача владельца.
