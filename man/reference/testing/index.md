# Тестирование проектов WM

Стандартное место URL-доступных smoke tests и dev examples:

```text
<project-root>/test/
```

Component-local test допустим только когда внутренний context невозможно
осмысленно вызвать из root test.

## Smoke matrix

1. `index.php` и bootstrap без fatal/warning.
2. Base и normal page.
3. Unknown URI с реальным HTTP 404.
4. Parent `is-mod` и nested URI.
5. Redirect с проверенными URI/status.
6. Project handler и page shell через `rMain`.
7. По одному template каждого используемого RM.
8. API GET, error и unknown route.
9. Mutation API: auth/ACL/CSRF/validation/recovery.
10. CSS, JS, image, font и `qv()`.
11. Vue 3 navigation, back/forward, direct URL и reload.
12. WD reference/live, если UI сравнивается.
13. MQR resize, только если он используется.

## Safety

Tests не используют production credentials, real customer data и большие
product JSON. Mutation работает с disposable fixture и явным cleanup.

PHP test совместим с 7.2, требует `short_open_tag=On` и использует короткие
framework tags.

## Формат результата

`pass` означает реально выполненный успешный test. `fail` — реально выполненный
и расходящийся с ожиданием. `blocked` фиксирует причину невозможности запуска.
`not run` не называется проверенным.

Запись включает revision, PHP/runtime, host/URL, expected, actual и evidence.
