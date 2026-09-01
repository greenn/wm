# Admin routing и Vue Router

Root rewrite должен пропустить физический `/admin`. Локальный
`admin/.htaccess` возвращает `admin/index.php` для deep client routes.

```text
GET /admin/users/42
  -> admin/.htaccess
  -> admin/index.php
  -> PHP auth + app shell
  -> Vue Router resolves /users/42
```

## Server responsibilities

- bootstrap IQ/project environment;
- session authentication;
- authorization для initial page и каждого API action;
- HTML shell, headers и status;
- fallback для direct URL/reload в history mode.

## Client responsibilities

Vue 3 и `vue-router` выполняют navigation, back/forward, route component и UX
guards. Скрытая кнопка, `v-if` или client guard не ограничивают прямой HTTP
доступ.

Hash history не отправляет fragment серверу. `createWebHistory()` требует
fallback на `admin/index.php`, а base должен соответствовать `/admin`. Static
assets и `/api` нельзя отдавать через SPA fallback.

## Known rewrite gap

`.vmk4/.htaccess` перехватывает `/admin` до проверки physical directory и
отправляет его в отсутствующий `/ap/router.php`. Для нового project правило
нужно строить вокруг физического `/admin`, а не восстанавливать legacy `ap`.
