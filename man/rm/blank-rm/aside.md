## Быстрая проверка

В DevTools должны появиться события вида:

```text
[blank/rm] bootstrap:success
[blank/rm] rm-connector:success
[blank/rm] client-check
```

### Главный маркер

`demo.class.inc` — не соглашение для красоты, а обязательная точка входа
component. Удаление или неверное имя connector должно дать управляемый FAIL.

### Граница теста

Здесь проверяется RM + template + source. Router, site settings, API, UV/qv и
Vue Router относятся к следующему project smoke.
