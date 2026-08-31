# `site`: IQ-сайт и named RM

## Два разных уровня

В WM слово `site` используется в двух ролях, которые нельзя смешивать:

1. Site environment (`iqSite`) — host/settings/pages/router/uv и общий контекст сайта.
2. Named RM `site` — базовые компоненты/шаблоны сайта по решению владельца.

Директория `<ROOT>/site` с `iq.inc`, settings, router, uv и web-connectors сама по себе не является корнем named RM. Физический root named RM задаёт его manager.

## Целевой канон

- `site` — basic named RM сайта.
- Прикладной проект имеет свой named RM, например `gss3`.
- `iqPro.rMain` определяет RM, через который built-in v2 router выводит `page/page` и `page/html`.
- Общая reusable site-логика может жить в `site`; брендовая и предметная логика остаётся в project RM.

## Текущее расхождение v2

В текущем коде v2 `site()` уже является accessor-ом `iqSite` (`web/php/site/v2/iq/iq-site.php`), а активного v2 manager/class/helper-комплекта named RM `site` не найдено. Реализация `class site`, `class _site`, `site_tpl()` присутствует только в `web/php/site/v1/r/site.class.php` и является legacy.

Поэтому будущий Codex обязан:

- не подключать v1 `site.class.php` в v2 автоматически;
- не описывать `site_tpl()` как гарантированно доступный v2 helper;
- не смешивать функцию `site()` IQ с RM dispatch;
- перед использованием `rMain=site` подтвердить активный v2 RM manager и connector;
- при отсутствии такого manager-а зафиксировать архитектурный gap и запросить решение владельца либо использовать подтверждённый project `rMain`.

Это спорное имя/API нельзя разрешать изобретением нового helper-а без решения владельца.

## Документирование site RM

Когда v2 implementation будет подтверждена, документация должна отдельно показать:

- IQ-site root и его файлы;
- root named RM `site`;
- manager/base class/helper-ы;
- components только по connector-ам;
- зависимости project RM от site RM;
- какие page shell/template принадлежат `site`, а какие project RM.
