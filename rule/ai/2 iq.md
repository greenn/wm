# IQ: подключение окружения сайта и проекта

## Назначение

IQ — connector окружения, а не RM connector. Он связывает HTTP bootstrap с `web`, site config и project config, регистрирует `iqSite`/`iqPro` и предоставляет env-вызовы.

Каноническая форма:

```text
entrypoint
  -> <project>/iq.inc
  -> site/iq.inc
  -> web connector + v2 IQ classes
  -> _iq::add_site(...)
  -> _iq::add_pro(...)
  -> current site/project
```

Фактический пример находится в `.vmk4/site/iq.inc`, `.vmk4/gss3/iq.inc`, `web/php/site/v2/iq/`.

## `iqSite`

`iqSite` хранит site root, host name, settings, router file и URL-version database. При стандартном `selfDir=true` site root становится `<DOCUMENT_ROOT>/site`. Site connector должен загрузить framework раньше, чем начнёт вызывать `_needphp()` и v2 classes.

Основные accessors v2:

```php
<?
$Site = site();
$host = site('hostName');
$SiteBySid = _site('gss');
```

Здесь `site()` относится к IQ, а не к named RM `site`.

## `iqPro`

Project IQ задаёт:

- project sid;
- абсолютный/относительный project root;
- `rMain`;
- env (`i`, `css`, `api`, `r`, `pages` и другие подтверждённые handlers);
- PHP environment file;
- CSS, `wdDir`, `pagesDir`, `routerDir`;
- current project.

Accessors:

```php
<?
$Pro = pro();
$pagesDir = pro('pagesDir');
$value = cur('someProp');
$rMain = cur_opt('rMain');
```

`cur()` сначала обращается к current project, затем при `null` — к current site. `cur_opt()` аналогично выбирает project option либо site option.

## Канон absolute/relative root

Должен быть задан ровно один непротиворечивый вариант:

- `selfDir` — абсолютный filesystem path проекта;
- `dirSelf` — относительный путь от `DOCUMENT_ROOT`, из которого вычисляется `selfDir`.

Нельзя передавать абсолютный path под ключом `dirSelf`: текущая логика добавляет к нему `DOCUMENT_ROOT`.

## Подтверждённые проблемы текущего кода

- `iq-pro.class.php` сейчас содержит `directAssignProps = array('selfDir', 'selfDir')`; `dirSelf` не назначается. Это надо исправить до объявления relative-config канонически рабочим.
- `.vmk4/gss3/iq.inc` передаёт абсолютный path как `dirSelf`, поэтому не соответствует ни одному корректному варианту.
- Строка `css/%sid-css.php` не раскрывается текущим `iqPro`; `css=true` строит `css/<sid>-css.php`, либо нужен точный relative path.
- Options `envFile` и `router` в примере gss3 текущий `iqPro` не использует.
- Метод `run()` существует, но constructor его автоматически не вызывает; строковый `run.inc` также не привязывается к project root.

Будущая документация должна показывать целевой contract и этот implementation gap отдельно. Не копировать `.vmk4/gss3/iq.inc` как рабочий blank до исправления и runtime smoke test.

## Проверка IQ

1. Установить реальные `DOCUMENT_ROOT`, `HTTP_HOST`, URI.
2. Проверить существование выбранного `web.php`.
3. Проверить site sid/current site и project sid/current project.
4. Проверить вычисленные `selfDir`, pages/router/wd paths.
5. Проверить загрузку project env classes до создания `envCaller`.
6. Проверить `rMain` и наличие его manager-а.
7. Выполнить root page, обычную page, 404, project router и API smoke tests.
