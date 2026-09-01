# Page data и страницы GSS3

Page file описывает серверную страницу декларативно. Поле добавляется только
если у него есть current consumer в pages v2 или project handler.

## Основные поля

| Поле | Назначение |
|---|---|
| `title`, `seo`, `og` | Заголовки, metadata и social context. |
| `page-ctx`, `html-ctx`, `app-ctx` | Context внутренней страницы, HTML shell и app. |
| `content`, `content-tpl`, `contents` | Inner content или template dispatch. |
| `router`, `router-ctx` | Project/server handler и его context. |
| `redirect` | URI и 3xx status. |
| `is-mod` | Parent page обслуживает вложенный URI. |
| `link` | Настройки URI/protocol/domain для ссылок. |
| `sitemap` | Участие страницы в индексации. |

## Семь страниц примера

| URI / PID | Назначение | Подтверждённая сборка |
|---|---|---|
| `/` → `index` | Титульная | `posts / tariffs`; component `posts` отсутствует — gap. |
| `/agent` | Ритуальный агент | `content / texts/agent/page-agent`. |
| `/catalog[/…]` | Каталог | `catalog`, handler `mod`, templates `catalog-titul`, `catalog-list`, `catalog-item`. |
| `/contacts` | Контакты | `contacts / content-contacts`. |
| `/docs` | Документы | `content / texts/docs/page-docs`. |
| `/service` | Услуги | `content / texts/service/page-service`. |
| fallback `404` | Страница ошибки | Active inline content; `uc/404` только закомментирован. |

Эти сведения получены из `.vmk4/gss3/pages/*.inc` без чтения product/catalog
JSON и settings.

## Catalog gap

Страница `catalog` подтверждает замысел nested handler. Но project handler
ожидает `Pid` и `r-class`, тогда как current v2 context передаёт `Uri`, а
`r-class` page data не задаёт. Snapshot нельзя копировать как готовый route.

## История страницы

Изменение URI, page fields, components, templates или client route записывают
в [журнал](doc:log/index) с привязкой к ID страницы и затронутым модулям.
