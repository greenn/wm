# PHP loaders и helpers

Выбирайте механизм по типу ресурса. Loader строит точный путь и не угадывает
`.class`, legacy suffix или другой namespace.

## Карта выбора

| Нужно | Механизм |
|---|---|
| Общий PHP helper | `_needphp('<name>')` |
| PHP library | `_lib('<name>')` |
| Project helper | `need_pro('<name>')` или проверенный project connector |
| Include с context/output | `inc*`, `qtpl`, `useTemplate` |
| RM component | `<component>.class.inc` через named manager |

## Current loaders

```php
_needphp(/* names */)
_addphp($phpName)
_needinc($incName)
_lib($libName)

need::php($phpName)
need::pro($phpName)
need::path($phpName, $dirPath = false)
need::lib($libName)
need::inc($incName)
```

`_needphp('file')` ищет ровно `web/php/file.php`. `_lib('kint')` ищет
`web/lib/kint/kint.php`. Include helpers исполняют выбранный файл и управляют
context/output; они не регистрируют module.

## Library connectors

Exact entries существуют для `kint`, `mobile-detect`, `mpdf`,
`PhpSpreadsheet`, `ptf` и `simple_html_dom`. `simple-scrollbar` — browser asset
directory без PHP connector.

Vendor surfaces не становятся global API WM. Перед использованием проверяют
PHP 7.2 compatibility, license, autoload conflicts, side effects и реального
consumer.

## Task-oriented families

- `fq` — arrays, properties и type helpers;
- `g`, `ck`, `s`, `x` — process/cookie/session/in-memory state;
- `json` и `J` — encoding и file-backed data;
- `responseData` — result/errors/actions/info;
- `scheme` — validation;
- `mysql`/`sd` — DB layer с unresolved aggregator target;
- `file`, headers, redirects, templates, generated CSS/JS и images —
  side-effect families, требующие отдельной проверки.

Полный agent-index symbols находится в `aidocs/php`; human docs показывают
канонический выбор и опасные границы.
