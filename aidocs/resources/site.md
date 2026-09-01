# Site environment и named RM site

Status: IQ site current; named RM `site` target/unresolved in v2.

## IQ site — подтверждённый слой

| Entry | Назначение |
|---|---|
| `site/iq.inc` | Создаёт web config и регистрирует site через `_iq::add_site()`. |
| `site/php/_webConnector.class.php` | Выбирает local/host web connector и загружает v2 IQ/pages/source/RM classes. |
| `web/php/site/v2/iq/iq-site.class.php` | `iqSite`: settings, domains, router и UV database. |
| `site/router.php` | Site router entry. |
| `site/settings/` | Host-specific config; значения закрыты и не переносятся в docs. |
| `site/uv/` | Canonical URL-version databases. |

Функции `site(...)` и `_site($sid, ...)` из
`web/php/site/v2/iq/iq-site.php` обращаются к IQ environment. Они не являются
RM dispatch.

## Named RM site — gap

Решение владельца: `site` должен быть basic named RM, а project-specific
markup/data остаются в project RM, например `gss3`.

В current v2 не найден manager/base/helper-комплект `_site/site/site_tpl` для
named RM. Он существует только в legacy
`web/php/site/v1/r/site.class.php`. Одновременно
`iqSite::defaultConfig()` задаёт `rMain = 'site'`. Поэтому это реальный
implementation gap.

До отдельного исправления:

- не подключать v1 site manager в v2 автоматически;
- не считать `site_tpl()` гарантированным v2 API;
- не смешивать IQ `site()` с RM call;
- для `rMain=site` сначала подтвердить manager и component `page`;
- в рабочем project временно использовать только подтверждённый project
  `rMain` и явно фиксировать решение.

## Текущее root расхождение

`site/iq.inc` и `site/php/_webConnector.class.php` являются существующим
snapshot, но их option names нужно проверять против current `iqSite/iqPro`
перед копированием. Settings не читать и не выводить. См. project-карты и
общий known-issues документ.
