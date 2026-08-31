# Named RM `rb`

## Роль

`rb` — Base Resources, базовый named RM фреймворка. Его manager находится в `web/php/site/v2/r/rb.class.php` и разрешает компоненты из:

```text
<ROOT>/r/rb
```

Короткие интерфейсы текущего v2:

```php
<?
_rb::req('page');
$Page = _rb::name('page');
$value = rb('page', 'method', $arg);
$html = rb_tpl('page', 'page', $ctx);
```

`rb` входит в обязательный переносимый комплект нового самостоятельного проекта. Если проект использует централизованный framework, всё равно надо подтвердить, откуда `ROOT/r/rb` реально доступен: соседний `web` сам по себе не меняет `ROOT` manager-а.

## Подтверждённые компоненты текущего дерева

Компонентами являются только каталоги с точным connector-ом:

```text
aos, api, blank, bz, chartjs, css, data, db, dbg, drozd,
json, lay, mqr, page, page-content, robots-txt, router, router2,
seo, sitemap, tgbot, uc-upd, vue, wd, xls, yamap
```

Каталоги `-ui`, `grid`, `grid-`, `log`, `system-`, `test`, `tool` не имеют одноимённого top-level connector-а и поэтому не должны автоматически описываться как components. Внутри них могут быть support, вложенные ресурсы, тесты или legacy; назначение устанавливается отдельным анализом.

## Граница ответственности

В `rb` находятся действительно общие ресурсы: page shell, page content, server routers, SEO/sitemap/robots, Vue helpers, `wd`, `mqr`, API-support и прочие базовые элементы. Проектная разметка и предметная логика должны оставаться в проектном RM.

Для v2 server routing главным является `router2`; наличие старого `router` означает совместимость/переходный код, а не разрешение строить новый routing на старом API.

## Правила работы

- Перед вызовом проверить connector и фактический public method/template.
- Не редактировать `rb` ради одной проектной страницы, если расширение можно оставить в project RM.
- Не копировать component из `rb` в project RM без необходимости.
- Не объявлять support-папку component-ом.
- При изменении базового component проверить всех известных consumers и обратную совместимость.
- Тесты по умолчанию размещать в root `test`, рядом с component — только когда иначе невозможно.

## Документация `rb`

Для каждого подтверждённого component будущий `aidocs` должен содержать connector/class, public methods, templates/calls, источники CSS/JS/Vue, API/data, dependencies и примеры реальных consumers. Большие data/JSON не читать целиком без необходимости.
