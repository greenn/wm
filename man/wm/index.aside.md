## Быстрый ориентир

```php
<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Project = pro();
$html = rb_tpl('page', 'page', $ctx);
```

> [!TIP]
> Сначала находите owner и manager ресурса, затем connector и только после
> этого template или API endpoint.

## Следующий шаг

Откройте архитектуру, чтобы проследить request от URL до project template.
