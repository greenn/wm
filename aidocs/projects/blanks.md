# .blank и .blank2

Status: blank, committed, technical repair required.

Blanks сохраняются как структуры для копирования и адаптации. Их наличие не
доказывает рабочий runtime. Исправление самих blanks выполняется отдельной
задачей/commit.

## .blank

`.blank` — legacy project form:

- entry `.blank/index.php` → `.blank/iq.inc` → legacy project router;
- `.blank/iq.inc` поднимает старый `iq` из `.blank/iq/php`;
- named RM `site` регистрируется через legacy `_site::reg()`;
- rewrite entry: `.blank/.htaccess`;
- private/local config tree `.blank/iq/config/settings` не читается и не
  переносится.

Matching `.blank/r/site` connectors — 18:

    app, banner, blank, contact, content, css, error, footer, header,
    hp, logo, menu, order, page, posts, search, titul, uc

Это legacy reference, не target v2 site RM implementation.

## .blank2

`.blank2` — более новый, но неполный snapshot:

- root `index.php` и `iq.inc` hard-code `/gss3/iq.inc`, которого внутри blank
  нет;
- содержит snapshots `api`, `css`, `js`, `r/rb`, `r/lay`, `site` и `wd`;
- `.blank2/r/lay` содержит те же 6 matching connectors;
- `.blank2/r/rb` содержит 25 matching connectors, older set без current
  `router2`:

      aos, api, blank, bz, chartjs, css, data, db, dbg, drozd, json, lay,
      mqr, page, page-content, robots-txt, router, seo, sitemap, tgbot,
      uc-upd, vue, wd, xls, yamap

- `site/iq.inc`/web mode и IQ option names требуют проверки;
- root `test` отсутствует; есть только `test-blank` examples.

Не синхронизировать snapshot массовым копированием текущего WM.

## Component blank

Component blank всё равно обязан иметь matching `<component>.class.inc`.
Каталог без connector — support/draft, даже если называется `blank`.

## Перед использованием

1. Выбрать минимальный project file set.
2. Сравнить с current v2 и `.vmk4/gss3`.
3. Заменить identifiers/paths/settings placeholders без копирования secrets.
4. Проверить все component connectors.
5. PHP 7.2 lint с `short_open_tag=On`.
6. Запустить root `test` smoke suite.

`.blank/test-blank` и `.blank2/test-blank` остаются examples; они не меняют
default test location.
