# HTTP rewrite и .htaccess

`.htaccess` связывает публичный URL с реальными server entry points. Его
нельзя документировать только списком regex: для каждой секции нужна цепочка
`URL -> rewrite -> PHP file -> router/component`.

Канонические ожидания:

- существующие public files/directories отдаются напрямую;
- обычные site URI попадают в согласованный PHP-router;
- root API направляется в `/api/index.php`;
- физическая admin-точка по умолчанию — `/admin/index.php`;
- `test` остаётся URL-доступным только в согласованной dev-среде;
- robots/sitemap/static routes соответствуют существующим handlers;
- settings, dotfiles, backups и служебные include-файлы не выдаются.

При разборе фиксировать порядок правил, `RewriteBase`, условия `-f/-d`,
query-string behavior, trailing slash, encoded URI, 404 и loop protection.
Текущий rewrite `/admin -> /ap/router.php` при отсутствующем `ap` — known
issue, не канон.

Глобальные изменения rewrite за пределами прямого задания сначала оформляются
как предложение в `man/sug` и требуют approval.
