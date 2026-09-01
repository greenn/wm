# PHP-карта WM

## Назначение

Этот раздел — навигация по собственному PHP-коду `web/php`, а не руководство
по PHP и не обещание стабильного public API. Перед изменением helper-а нужно
открыть его точный файл, проверить его реальные consumers и выполнить lint в
PHP 7.2 с `short_open_tag=On`.

Начальные точки:

- [loading.md](loading.md) — как `web/web.php`, `_needphp()`, `need` и `_lib()`
  действительно подключают код;
- [module-index.md](module-index.md) — полный индекс 126 верхнеуровневых
  `web/php/*.php` entry-файлов;
- [families.md](families.md) — локальные подпапки, классы, helpers и основные
  call chains;
- [data-and-state.md](data-and-state.md) — массивы, paths, globals, cookie,
  session, JSON, response и DB;
- [io-http-rendering.md](io-http-rendering.md) — filesystem, URL/HTTP, headers,
  templates, CSS/JS и изображения;
- [legacy-and-risks.md](legacy-and-risks.md) — конфликтующие поколения,
  отсутствующие targets и зоны, которые нельзя копировать в новый код вслепую;
- [../libraries.md](../libraries.md) — отдельный library connector `_lib()`.

## Статусы

| Статус | Значение |
|---|---|
| current | Реализация входит в действующую loader/v2-цепочку или имеет подтверждённых current consumers. Это не гарантия стабильности API. |
| support | Локальный файл семейства; подключать через владельца/aggregator, если тот работает. |
| legacy | Историческая реализация, вариант с `-`, `v1`, prototype/debug/test либо код, вытесненный текущей v2-цепочкой. |
| unresolved | В коде есть несовпадение loader contract-а, отсутствующий target или неясный активный consumer. Сначала проверить, потом использовать. |

## Граница инвентаризации

Инвентаризация, собранная 2026-08-31, дала два разных знаменателя:

- 408 физических собственных `*.php` вне `vendor`/`node_modules` по прямому
  filesystem inventory;
- 395 `*.php`, видимых через `rg --files` с действующими ignore-правилами;
- 126 верхнеуровневых entry-файлов;
- 351 файл с найденной декларацией функции, метода, класса, interface или trait;
- 761 декларация глобальной функции, начинающаяся с `function` в нулевой
  колонке;
- 2 393 named function/method definitions по независимому naive regex scan;
- 2 612 строк функций/методов/classes/interfaces/traits по более широкому
  line-based scan 395 `rg`-видимых файлов;
- 44 PHP support/aggregator/router/template файла без деклараций;
- 75 `*.inc` фрагментов, главным образом `pcss`/JS/template config; они учтены
  как support-файлы, но не выданы за function modules.

Разница 408/395 означает, что ignore-aware список нельзя выдавать за физически
полный. Этот раздел полностью перечисляет 126 top-level entries и все
обнаруженные семейства, но не обещает построчного описания каждого из 2 393
methods/functions. Числа служат coverage baseline, а не PHP-parser-ом:
вложенная декларация или многострочная сигнатура требует чтения исходника.
Product/content JSON не читались. Vendor и minified assets не обходились
массово.

## Правила изменения

1. Для общего helper-а сначала искать entry в `module-index.md`, затем точный
   файл в `families.md`.
2. Не угадывать имя загрузки по имени класса: `_needphp('x')` всегда ищет
   ровно `web/php/x.php`.
3. Не подключать library через `_needphp()` и не считать
   `<component>.class.inc` PHP-library.
4. Сохранять PHP 7.2 и короткие теги framework-а.
5. Не исправлять legacy-файл попутно, если задача относится к current v2.
6. После добавления/переноса функции обновить этот индекс и её call chain.
