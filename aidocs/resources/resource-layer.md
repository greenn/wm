# Resource layer

Status: current v2.

## Точки входа

| Путь | Роль |
|---|---|
| `web/php/rw/rw.class.php` | Поведение одного ресурса: config, path/URI, temp context, `tpl()` и `call()`. |
| `web/php/rw/_rw.class.php` | Manager: вычисление connector path, регистрация, lazy load и cache. |
| `web/php/rw/_r.php` | Generic dispatch: `r_()`, `r()`, `tpl()` и внутренние helpers. |
| `web/php/site/v2/r/rt.class.php` | v2 resource type: source CSS/JS/Vue, API helpers и `db()` call. |
| `web/php/site/v2/r/rb.class.php` | Manager/base/helpers named RM `rb`. |
| `web/php/site/v2/r/lay.class.php` | Manager/base/helpers named RM `lay`. |

## Разрешение component

    named helper
      -> manager named RM
      -> manager::req(component)
      -> <rm-root>/<component>/<component>.class.inc
      -> manager::reg(component, config)
      -> component class
      -> method, tpl(), call(), CSS/JS/Vue/API

`_rw::req()` возвращает `false`, если connector отсутствует. Не создавать
connector автоматически по одному факту существования директории.

## Public формы

    _rb::req('page');
    $Page = _rb::name('page');
    $value = rb('page', 'method', $arg);
    $html = rb_tpl('page', 'page', $ctx);

    _lay::req('pic');
    $html = lay_tpl('pic', 'img', $ctx);
    $value = lay('pic', 'applyCtx', $ctx);

Generic `r($rClass, $name, $method, ...)` допустим, когда RM выбирается
динамически. Для обычного вызова предпочтителен named helper.

## Paths и context

`rw::path()` и `rw::uri()` строят location от зарегистрированного `rDir`.
`rw::tpl()` помещает context в stack, включает template через output buffering
и возвращает строку. `rw::call()` делает то же для `*.inc` через `inc()`.

Не собирать filesystem path вручную, если manager уже предоставляет
`path()/uri()/tpl()/call()`. Исключение — существующий contract внешнего
handler path, явно передаваемый массивом в `tpl()`.

## Добавление RM/component

- Для нового named RM нужны manager, base class и короткие helpers в project
  environment.
- Для нового component обязателен точный `<name>.class.inc`.
- Component-specific templates, CSS, JS, Vue и data хранятся рядом.
- Общую зависимость переносить в `rb`, `lay`, `web/php` или `web/lib` только
  после подтверждённого повторного использования.
- PHP нового component совместим с PHP 7.2 и использует short tags.
