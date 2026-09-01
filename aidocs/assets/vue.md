# Vue

Status: Vue 3 current; repository corpus содержит legacy Vue 2.

## Runtime и source pair

Current source engine: `web/php/site/v2/source.class.php::vue`.
RM adapter: `web/php/site/v2/r/rt.class.php`.
Base component: `r/rb/vue/vue.class.inc`.

Component pair:

    <owner-component>/<name>.vue.tpl.inc
    <owner-component>/<name>.vue.js.inc

Вызов идёт через `req_vue()`/`vue_req()` owner RM. Source engine выполняет обе
части для dependencies, затем экспортирует template как
`<script type="text/x-template">` и JS declaration.

`r/rb/vue/vue-init.js.inc` использует `Vue.createApp()`. Подтверждённые
Vue 3 browser assets: `js/vue/3.2.20/vue.global.js` и tree
`js/vue/3.2.36`. Существующие UV databases ссылаются на 3.2.20; менять version
можно только отдельной проверенной задачей.

Связанные current-major assets:

- `js/vue-router/4.0.12`;
- `js/vuex/4.0.2`;
- `js/vuetify/3.3.14`.

## Mixed tree

`r/rb/vue` содержит current engine/support (`env-js`, `provide`, `s`) и
большие `test`, `tests`, `re` trees. В них есть как Vue 3
`Vue.createApp()`, так и Vue 2 `new Vue()/Vue.component()`; например
`r/rb/vue/tests/eg8/index.php` грузит Vue 2. Эти примеры имеют status legacy
или research и не копируются в новый код.

## Router boundary

`vue-router` нужен внутри приложения, каталога или корзины для client
transitions/back-forward. PHP-router всё равно выбирает initial HTML/server
page; direct URL и reload обязаны вернуть тот же app entry либо корректный 404.

## Checklist

- Подтвердить Vue 3 runtime до копирования fragment.
- Не переносить Vue 2 plugin/options APIs без адаптации.
- Не добавлять build pipeline только ради component pair.
- Server auth/ACL не заменять client guard.
- Описать props/context, mount point, initial state, API, routes и cleanup.
- Проверить loading/error states, back/forward и direct reload.
