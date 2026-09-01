# CSS и JavaScript

Status: current source contract; vendor directories имеют собственные versions.

## Source manager

Реализация: `web/php/site/v2/source.class.php`.

- `source::req()` дедуплицирует одинаковые request arguments;
- `js::req()` и `css::req()` складывают ordered sources;
- `rt::req_js()` по умолчанию разрешает component file как `*.js.php`;
- `rt::req_css()` по умолчанию разрешает component file как `*.css.php`;
- `_source::html_export()` выводит CSS, JS, затем Vue;
- URL source по умолчанию проходит через `qv()`;
- inline content допустим через source context, но не должен дублировать
  внешний asset.

Пример component source:

    $Self = _rb::self();
    $Self::req_css(-1, 'view');
    $Self::req_js('view');

Не собирать URL из filesystem path вручную; RM уже предоставляет `uri()`.
PHP-generated CSS/JS обязан вернуть корректный Content-Type/charset и не
вывести PHP warning.

## Shared CSS roots

| Provider | Подтверждённый root |
|---|---|
| Animate.css | `css/animate/411` |
| CSShake | `css/csshake/1.7.0` |
| Materialize | `css/materialize/1.0.0` |

Текущие WM base styles находятся не здесь, а в component `r/rb/css`:
`base.css.php`, `common.css.php`, `flex.css.php`, `reset.css.php`,
`aq.css.php` и `ft.css.tpl.php`.

## Shared JavaScript roots

Эти paths — browser assets, не PHP library connectors.

| Provider | Versions/entry roots в snapshot |
|---|---|
| AOS | `js/aos/1.2.0`, `2.3.1`, `2.3.4`, `3.0.0b6` |
| Axios | `js/axios/0.24.0` |
| Chart.js | `js/chartjs/4.2.1`, `4.4.4` |
| Chart plugins | `js/chartjs-plugin-annotation/2.2.1`, `js/chartjs-plugin-datalabels/2.2.0` |
| jQuery | `js/jquery/1.12.4` |
| jQuery UI datepicker | `js/jquery-datepicker/1.12.1`, `1.13.0` |
| Lodash | `js/lodash/4.17.21` |
| IMask | `js/imask/6.2.2` |
| Moment | `js/moment.js/2.29.1`, `moment-range/4.0.2`, `moment-timezone/0.5.34` |
| QS | `js/qs/6.5.1`, `6.10.3` |
| RxJS | `js/rxjs/7.5.5` |
| Vue | `js/vue/3.2.20`, `3.2.36` |
| Vue Router | `js/vue-router/4.0.12` |
| Vuex | `js/vuex/4.0.2` |
| Vuetify | `js/vuetify/3.3.14` |
| Waypoints | `js/waypoints/4.0.1`, `4.0.1c`, `4.0.1l` |
| Other current roots | `emittery/0.6.0`, `knockout/3.5.1`, `mitt/3.0.0`, `rxjs-jquery/1.1.6`, `tiny-emitter/2.1.0`, `vivus/0.4.6`, `w-storage/5.0.0` |

`vue-material`, `vue-material-components`, `vue-datepicker`, old Vuelidate and
research/test assets can encode Vue 2 assumptions. Проверять compatibility с
Vue 3 до подключения.

## Проверка

1. Найти единственного owner/loader.
2. Убедиться, что URL существует и не подключён вторым механизмом.
3. Проверить order/dependencies.
4. Проверить HTTP status и Content-Type.
5. Изменить asset, убедиться, что `qv` изменился и browser загрузил новый URL.
6. Проверить production mode без debug-only sources.
