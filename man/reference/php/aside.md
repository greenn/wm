## PHP helper

```text
_needphp('file')
  -> need::php('file')
  -> web/php/file.php
  -> file/* helpers
```

## Library

```text
_lib('mobile-detect')
  -> need::lib(...)
  -> exact library entry
  -> Mobile_Detect
  -> mobileMode()
```

> [!WARNING]
> `r.php`/`r2.php`, v1/v2 classes и alternate clamp/parser files могут
> объявлять одинаковые symbols. Не подключайте поколения вместе.
