## Render path

```text
pages/catalog.inc
  -> router = mod
  -> project handler
  -> gss3/catalog
  -> catalog templates
  -> gss3/page
```

## Redirect

```php
<?
return array(
    'redirect' => array('/new-uri', 301),
);
```

URI и status валидируются до отправки `Location`.
