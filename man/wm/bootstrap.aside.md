## Public accessors

```php
<?
$Site = site();
$host = site('hostName');

$Project = pro();
$pagesDir = pro('pagesDir');

$value = cur('property');
```

`site()` и `pro()` обращаются к IQ environments. `cur()` сначала смотрит
current project, затем current site.

> [!WARNING]
> Функция `site()` занята IQ. Не выдавайте её за dispatch будущего named RM
> `site`.
