# Vue

Новый интерфейс WM создаётся на Vue 3. Vue 2 остаётся только в legacy.

WM допускает CDN/runtime-подключение и PHP-generated fragments без обязательной
сборки. В существующих components встречаются пары:

    <name>.vue.tpl.inc
    <name>.vue.js.inc

Они документируются вместе с owner component, props/context, зависимостями и
mount point. Наличие такого файла само по себе не делает каталог RM-component.

`vue-router` применяется внутри приложения, каталога или корзины, когда нужны
client transitions и история назад/вперёд. PHP-router всё равно выбирает
server page/entry HTML; direct URL и reload должны иметь server fallback.

Правила нового Vue-кода:

- подтвердить версию Vue и способ загрузки до копирования примера;
- не переносить Vue 2 options/plugins без адаптации;
- не вводить build pipeline только ради одного component;
- server-side auth/ACL не заменять client guards;
- API errors и loading states отражать явно и логировать безопасно;
- icon-only controls снабжать доступным именем/title;
- документировать initial state, API, routes и cleanup.
