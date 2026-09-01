# `web/lib` и `_lib()`

## Connector contract

Library `<name>` существует для WM connector-а только при наличии exact entry:

```text
web/lib/<name>/<name>.php
```

Подключение:

```php
<? _lib('<name>'); ?>
```

`_lib()` определён в `web/php/need.php` и вызывает `need::lib($name)`. Тот
строит `LIB.'/'.$name.'/'.$name.'.php'`, проверяет файл, делает tracked
`include_once`. Library connector отличается от `_needphp()`, IQ и RM connector
`<component>.class.inc`.

## Фактические entries

| Name для `_lib()` | Exact entry | Что подключает | Подтверждённый consumer / статус |
|---|---|---|---|
| `kint` | `web/lib/kint/kint.php` | `kint-master/Kint.class.php`; добавляет debug aliases и `kint_source()` | `web/web.php`, `web/php/dbg.php`; current debug bootstrap |
| `mobile-detect` | `web/lib/mobile-detect/mobile-detect.php` | `Mobile-Detect-2.8.31/Mobile_Detect.php` | `web/php/isMobile.php`; support |
| `mpdf` | `web/lib/mpdf/mpdf.php` | `MPDF57/mpdf.php` | runtime consumer не подтверждён инвентаризацией; legacy/unresolved |
| `PhpSpreadsheet` | `web/lib/PhpSpreadsheet/PhpSpreadsheet.php` | local `vendor/autoload.php` | runtime consumer/version не подтверждены; legacy case-sensitive name |
| `ptf` | `web/lib/ptf/ptf.php` | `ptf-master` DBHelper/model files; запрашивает `_needphp('mysql')` | `web/lib/ptf/test/index.php`; test/legacy, DB-sensitive |
| `simple_html_dom` | `web/lib/simple_html_dom/simple_html_dom.php` | `simplehtmldom_1_9_1/simple_html_dom.php`; placeholders `file_get_sr`, `url_get_html` | entry существует, runtime consumer не подтверждён |

`web/lib/simple-scrollbar/` не имеет
`web/lib/simple-scrollbar/simple-scrollbar.php`, поэтому это asset directory, а
не PHP library connector.

ZIP archives и произвольные directories в `web/lib` тоже не образуют connector.

## Call chains

```text
web/web.php
  -> include web/php/need.php
  -> _lib('kint')
  -> need::lib('kint')
  -> include_once web/lib/kint/kint.php
  -> include_once Kint.class.php
```

```text
_needphp('isMobile')
  -> web/php/isMobile.php
  -> _lib('mobile-detect')
  -> Mobile_Detect
  -> mobileMode($set = null)
```

```text
_lib('ptf')
  -> web/lib/ptf/ptf.php
  -> _needphp('mysql')
  -> mysql_conf(...) for DB configuration
  -> DBHelper/models
```

Последняя цепочка чувствительна к credentials и к unresolved target
`mysql/sd.class.php`; не использовать её как пример current project storage.

## Public surface и ограничения

- Kint aliases могут вывести arbitrary values и завершить execution (`dx`);
  запрещено выводить secrets/product dumps.
- `mobile-detect` предоставляет upstream class `Mobile_Detect`; framework entry
  `mobileMode()` находится в `web/php/isMobile.php`.
- mPDF, PhpSpreadsheet и Simple HTML DOM имеют большие upstream surfaces.
  Здесь они не разворачиваются в method reference; перед изменением читать
  exact entry и минимально нужный upstream API.
- `ptf` настраивает static DB config при include — само подключение имеет
  environment dependency.
- `simple_html_dom` определяет два пустых framework placeholders; их нельзя
  считать реализованным public API.

Vendor contents, composer metadata и minified assets не обходились массово;
versions выше взяты только из exact connector paths/директорий. License и
актуальность upstream не подтверждены этим этапом.

## Добавление/обновление

1. Проверить, нет ли существующего PHP helper-а или library.
2. Для нового name использовать kebab-case и exact `<name>/<name>.php`.
3. Entry должен локально подключать vendor/classes; consumer вызывает только
   `_lib('<name>')`.
4. Проверить PHP 7.2, upstream version/license, autoload conflicts и реальные
   consumers.
5. Не обновлять vendor и не делать library глобальной зависимостью без
   отдельной задачи владельца.
6. Записать side effects, public entry API и call chain в этот файл.
