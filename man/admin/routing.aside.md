## History mode

```text
/admin/users/42
  -> server: /admin/index.php
  -> client base: /admin
  -> route: /users/42
```

## Hash mode

```text
/admin/#/users/42
  -> server sees /admin/
  -> client sees /users/42
```

> [!WARNING]
> `admin/.htaccess` сейчас не исключает real relative assets. Проверяйте CSS,
> JS, images и unknown client route реальными HTTP-запросами.
