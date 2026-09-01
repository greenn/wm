# .htaccess и rewrite chains

Rewrite читается сверху вниз вместе с per-directory context. `[L]` завершает
текущий pass, но internal rewrite может запустить следующий.

## Каноническая project chain

```text
existing public file/dir -> Apache directly
/api/...                 -> api/index.php
/admin[/...]             -> admin/index.php
ordinary site URI        -> site/router.php
```

Special routes добавляются только при существующем target. Settings, `.inc`,
dotfiles, backups и private data закрываются server config; отдельный data
gate — только дополнительная защита.

## Что проверять в правиле

- порядок admin/API до site fallback;
- `!-f`/`!-d` и DirectoryIndex для пустого path;
- loop при rewrite в `index.php`;
- query string, encoded URI, double/trailing slash и case;
- реальное существование static target;
- 403/404/405/503 statuses;
- HTTPS за trusted proxy без loop/spoofing.

## Current examples

Committed `api/.htaccess`, `admin/.htaccess` и `wd/.htaccess` используют child
front controllers. `.vmk4/.htaccess` полезен как v2-shaped example, но admin
route уводит в отсутствующий `ap`. `.blank` ведёт в отсутствующий legacy
router; `.blank2` ближе к v2, но тоже не является runnable project.

> [!WARNING]
> Глобальный rewrite вне прямого задания сначала оформляется как proposal.
> После изменения выполняется реальная HTTP-матрица, а не только чтение regex.
