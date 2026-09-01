# Templates

Status: current contract; отдельные template trees могут быть legacy/blank.

## Base contract

Реализация: `web/php/rw/rw.class.php`.

    rb_tpl('page', 'page', $ctx)
      -> rb('page', 'tpl', 'page', $ctx, 'tpl.php')
      -> rw::tpl_path()
      -> rw::temp_push($ctx)
      -> output buffering + include
      -> rw::temp_pop()
      -> HTML string

В template owner component обычно получается через `_<rm>::self()`, а context:

    $Self = _rb::self();
    $_ctx = $Self::tempCtx(array(
        'title' => '',
    ));

Defaults локальны. Обязательные значения нельзя незаметно превращать в пустые.
Данные экранируются по HTML/attribute/URL/JS контексту.

## Имена

- Обычный template: `<component>/<name>.tpl.php`.
- `lay::tpl('name')` сначала пробует
  `<component>/name/name.tpl.php`.
- `rw::call('path')` вызывает `<component>/path.inc` и возвращает результат
  `inc()`.
- Массив path в `tpl()` означает существующий explicit external template path;
  не использовать его для обхода RM в новом коде.

Template directory без собственного matching `<name>.class.inc` не является
component.

## Assets рядом с template

`rt` предоставляет `req_css()`, `req_js()`, `req_vue()` и `vue_req()`.
Component-specific CSS/JS/Vue остаются рядом с owner component. Source manager
дедуплицирует одинаковые request arguments и экспортирует HTML через
`_source::html_export()`.

Vue pair:

    <name>.vue.tpl.inc
    <name>.vue.js.inc

Обе части разрешаются через owner RM. `vue::html_export_cb()` выводит
`text/x-template` и JS declaration. Для нового кода pair должен соответствовать
Vue 3; наличие пары в legacy/test tree этого не гарантирует.

## Проверка

- PHP 7.2 lint с `short_open_tag=On`;
- вызов только через зарегистрированный component;
- минимальный явный context;
- отсутствие warning/notice в HTML/CSS/JS output;
- проверка вложенных templates и source order;
- XSS-safe output;
- реальная page/consumer, а не только direct include.
