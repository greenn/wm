# blank/rm: первый исполняемый RM-тест

`blank/rm` — маленькая самостоятельная страница, на которой можно увидеть весь
базовый контракт named Resource Manager без project router и базы данных.

## Что проходит через framework

```text
blank/rm/index.php
  -> blank/rm/iq.inc
  -> iqPro «blank-rm»
  -> _blankRm::req('demo')
  -> r/demo/demo.class.inc
  -> blankRmTpl('demo', 'card')
  -> card.tpl.php
```

Страница не подключает template по физическому пути. Она просит `blankRm` найти
component `demo`, после чего RM разрешает шаблон `card` через свой API.

CSS и JavaScript регистрируются методом component:

```php
blankRm('demo', 'registerSources');
$sourceHtml = _source::html_export();
```

В результате браузер получает URL `demo.css.php` и `demo.js.php`, вычисленные
resource layer относительно физического root RM.

## Шесть сигналов

Страница показывает отдельный результат для:

- bootstrap общего `web`;
- текущего `iqPro`;
- matching connector `demo.class.inc`;
- template API;
- CSS/JS source manager;
- ожидаемого отказа для отсутствующего resource.

Первые пять сигналов обязательны. При ошибке сервер отвечает `500`, выводит
безопасный код, а подробную причину отправляет в PHP error log. Отсутствующий
component, напротив, должен вернуть `false`: это подтверждает, что каталог или
имя не превращаются в resource автоматически.

## Как открыть

Нужно отдать корень WM через PHP 7.2 с `short_open_tag=On` и открыть:

```text
/blank/rm/
```

Успешный реальный запуск — это HTTP 200, шесть зелёных карточек, итог `PASS` и
два успешных asset request. JavaScript дополнительно читает CSS sentinel через
`getComputedStyle`, поэтому одной сформированной ссылки на stylesheet
недостаточно. Все этапы видны в browser console.

> [!WARNING]
> В текущем окружении Codex не найден ни PHP CLI, ни настроенный PHP web server.
> Поэтому структура, PHP 7.2 syntax surface, manifest и JavaScript проверены
> статически, а HTTP/PHP runtime честно имеет статус `Not run`.

Этот тест специально не включает `qv`: нормальная UV/qv-цепочка проверяется уже
в полноценном проекте `wm-0`, а не маскируется внутри изолированного примера.
