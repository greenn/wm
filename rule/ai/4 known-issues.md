# Known issues, обнаруженные при этапе =1

Ниже зафиксирована диагностика current snapshot. Это не разрешение исправлять
проблемы в рамках формирования `rule/ai`.

## .vmk4/bootstrap

1. Активный `.vmk4/site/web/web[self].inc` ожидает
   `<DOCUMENT_ROOT>/web/web.php`, которого в snapshot `.vmk4` нет. Общий
   `J:\dv\wm\web` автоматически не подключается.
2. `.vmk4/gss3/iq.inc` передаёт абсолютный path как `dirSelf`; contract
   требует абсолютный `selfDir` либо относительный `dirSelf`.
3. `iqPro::$directAssignProps` содержит `selfDir` дважды и не назначает
   `dirSelf`.
4. CSS option `css/%sid-css.php` не интерполируется current `iqPro`.
   Поддержан `css=true` либо конкретный path.
5. `index.php` использует `fileRouter`, тогда как `iqSite` предоставляет
   `routerFile`.

## Pages/router/RM

6. `site_router::handlerPath()` добавляет `/router` к `routerDir`, который
   уже может указывать на `<project>/router`; получается двойной сегмент.
7. Catalog custom router ожидает `Pid`, основной router передаёт `Uri`; в
   page config также отсутствует ожидаемый `r-class`.
8. `pages/.map.inc` отсутствует; не все sitemap URL соответствуют реальным
   page files.
9. Сохранились ссылки на отсутствующие RM/components `seo` и `posts`.
10. Rewrite `/admin` указывает на отсутствующий `ap`, хотя default владельца
    — физический `/admin/index.php`.

## Shared resources и безопасность

11. В `.vmk4` нет local `r/rb`, `r/lay` и `web`; shared/copy strategy
    должна быть настроена явно, одного соседства с WM недостаточно.
12. В excluded project settings обнаружены plaintext credentials/tokens.
    Значения не читались в документацию, не должны копироваться или
    коммититься; нужна отдельная безопасная миграция конфигурации.

Перед этапами `=4` и `=5` эти пункты надо перепроверить, выбрать минимальные
исправления и закрыть smoke tests отдельными commits.
