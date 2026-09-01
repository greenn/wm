# SITE — environment и целевой RM

Слово `site` обозначает два разных слоя. Их нельзя смешивать.

## IQ site — current

`site/iq.inc`, `_webConnector`, `iqSite`, `site/router.php`, `site/settings` и
`site/uv` образуют окружение сайта. Functions `site()` и `_site()` обращаются к
IQ environment.

## Named RM site — unresolved

Целевой basic RM `site` должен владеть общими page shell/components, оставляя
project content в `gss3`. В current v2 manager/base/helpers `_site`, `site`,
`site_tpl` для named RM не подтверждены.

```text
current v2 matching site RM components: 0
```

`iqSite::defaultConfig()` уже задаёт `rMain=site`, поэтому отсутствие manager
— реальный implementation gap. До исправления используют подтверждённый
project `rMain` и не подключают v1 manager автоматически.

## Legacy reference

`.blank/r/site` содержит 18 matching legacy connectors:

```text
app, banner, blank, contact, content, css, error, footer, header,
hp, logo, menu, order, page, posts, search, titul, uc
```

Этот список помогает при миграции, но не является current v2 catalog.

> [!WARNING]
> IQ function `site()` нельзя переопределить как RM dispatch. Новый contract
> должен выбрать недвусмысленные manager/helpers и пройти page smoke suite.
