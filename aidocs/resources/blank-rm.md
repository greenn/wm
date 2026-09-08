# blank/rm — исполняемый v2 named RM

Status: current; PHP 7.2.34 + HTTP + browser PASS, 2026-09-08.
Результат `=4` в ветке `astra-high`, база `82a7f90`, версия WM `20.0.5`.

## Entry и ownership

```text
blank/rm/index.php
  -> iq.inc -> shared web/web.php
  -> site/v2/iq + source.class + r/rt.class
  -> _iq::add_pro('blank-rm', ..., true)
  -> blank-rm.env.inc: blankRm / _blankRm / helpers
  -> _blankRm::req('demo') -> r/demo/demo.class.inc
  -> blankRmTpl('demo', 'card', $ctx) -> r/demo/card.tpl.php
```

`selfDir` абсолютный; `ROOT` — корень WM. Изолированный `iqPro` не читает site
settings, не подключает DB, router, pages или `wd`. Это пример внутри WM, а не
полный project skeleton. `.blank` — legacy reference; известные gaps `.vmk4`
не переносятся и не исправляются этим этапом.

`_blankRm::rDir()` возвращает `blank/rm/r`. Manager наследует `_rt`, resource
base — `rt`; собственные `db`, `cache` и template stack не смешиваются с другими
named RM. Только точный `demo/demo.class.inc` регистрирует компонент.

## Template и assets

`blankRmTpl('demo', 'card', array('title' => $title))` использует `_r_tpl` и
`rw::tpl()`. Template читает `static::tempCtx()`, экранирует title, возвращает
HTML section с `data-rm-card`. Единственный page consumer — `index.php`.

`blankRm('demo', 'registerSources')` вызывает `req_css(-10, 'demo', 'css', false)`
и `req_js(10, 'demo', 'js', false)`. `_source::html_export()` создаёт ссылки:

- `/blank/rm/r/demo/demo.css`;
- `/blank/rm/r/demo/demo.js`.

Это статические component assets с явно заданным расширением. Последний аргумент
отключает `qv()` только в изолированном smoke без site/UV. Нормальный project
проверяет UV/qv отдельно; canonical directory остаётся `site/uv`.

## Diagnostics

Все шесть проверок обязательны: bootstrap, iq-pro, connector, sources,
missing-resource, template. Отсутствующий ресурс должен вернуть `false` и из
`req()`, и из `name()`. Страница явно показывает ожидаемый отказ.

Любой failed check даёт HTTP 500, код `blank-rm-contract-failed`; exception —
`blank-rm-load-failed` с технической причиной в PHP error log. Буфер не выпускает
неожиданный вывод bootstrap или незавершённого template в response.

Inline `console.log` показывает серверные этапы даже при отсутствии внешнего JS.
Внешний JS подтверждает шесть зелёных строк и CSS sentinel `--rm-demo-loaded: 1`
на настоящем template. Итог `PASS` появляется только после этих проверок.
Без JS остаётся текст «Сервер: PASS · проверяем браузер…».

## Запуск и доказательства

Из корня WM, имея PHP 7.2 в PATH:

```powershell
php -n -d short_open_tag=1 -S 127.0.0.1:18724 -t .
```

Открыть `http://127.0.0.1:18724/blank/rm/index.php` или `/blank/rm/`.
В этой рабочей среде найден PHP:
`C:/S17/OpenServer/modules/php/PHP_7.2/php.exe`.

Проверено: lint всех пяти PHP/inc, `node --check` JS; HTTP 200 страницы, CSS
(`text/css`) и JS (`application/javascript`); browser PASS и повторная кнопка;
экранирование `<script>` в title; пустая строка при missing template;
контролируемые HTTP 500 при поочерёдном отсутствии connector, template, CSS, JS,
затем восстановление HTTP 200. В error response нет warning/fatal или путей.

Визуально проверены desktop и 390×844: сетка 3/2 колонки, без горизонтального
переполнения. Скриншоты: [desktop](../../man/wm/blank-rm/desktop.png),
[mobile](../../man/wm/blank-rm/mobile.png).

Apache `.htaccess` запрещает listing, `.inc` и `.tpl.php`. Apache-проверка
**not run**: запуск выполнен встроенным PHP server, который `.htaccess` не
обрабатывает. Этот localhost server — только средство локальной проверки.

Human guide: [man/wm/blank-rm/index.md](../../man/wm/blank-rm/index.md).
