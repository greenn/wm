## Минимальная page

```php
<?
return array(
    'title' => array(
        'page' => 'Контакты',
    ),
    'content-tpl' => array(
        'contacts',
        'content-contacts',
    ),
);
```

## Router context

```text
exact PID
  -> page data

parent is-mod
  -> page data
  -> subParts + subUri
```

> [!WARNING]
> Отрисованная 404-страница ещё не означает HTTP status 404.
