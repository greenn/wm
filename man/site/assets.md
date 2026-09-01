# Assets и client app сайта

Project-wide assets живут в `css/`, `js/`, `fonts/` и `i/`. Component-specific
CSS, JS и Vue pair остаются рядом с owner component и подключаются через его
RM.

## Images

`i(...)` вызывает image environment current project, а `_i('gss3', ...)` —
named project. Static `_i::...` работает с `<ROOT>/i`; это другой API.

```text
_i('gss3', 'uri', 'logo/logo.svg')
_i::uri('icons/search.svg')
```

Raw SVG выводится только из доверенного файла. Для изображения задают alt,
dimensions и loading policy.

## URL versioning

Canonical database находится в `site/uv`. `qv()` добавляет query `qv` и
помогает браузеру получить новую версию изменённого asset. Timestamp на каждый
request не используется.

## Vue 3 и history

Component pair состоит из `<name>.vue.tpl.inc` и `<name>.vue.js.inc`. Для
нового app используется Vue 3. Client route может управлять catalog/cart, но
server page и auth остаются в PHP.

## Проверка

- URL отвечает 200 и правильным Content-Type;
- generated CSS/JS не содержит PHP warning;
- dependencies загружены в правильном order;
- после изменения меняется `qv` и browser получает новый response;
- font/image CORS и fallback работают;
- direct Vue route и reload возвращают ту же shell.
