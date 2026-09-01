## Flex template

```php
<?
$html = lay_tpl(
    'flex',
    '2-cols-grow-first',
    array(
        'content1' => $main,
        'content2' => $aside,
    )
);
```

## Image context

```php
<?
$ctx = lay('pic', 'applyCtx', $ctx);
```
