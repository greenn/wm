# Результат 3: минимальный `blank/rm`

Дата: 2026-09-01. Версия результата: `20.0.5`.

Этап `=4` добавил первый committed executable smoke для отдельного v2 named RM.

## Реализовано

- entry `blank/rm/index.php` и отдельный `iqPro` без site/router/db;
- named RM `blankRm/_blankRm` с физическим root `blank/rm/r`;
- matching component `demo/demo.class.inc`;
- template `card.tpl.php`, вызываемый только через `blankRmTpl`;
- CSS/JS endpoints, зарегистрированные через `req_css/req_js` и
  `_source::html_export()`;
- шесть серверных сигналов, client DOM/CSS-sentinel check и подробные console
  events, включая безопасный fallback при ранней bootstrap-ошибке;
- управляемый HTTP 500 для critical failure и ожидаемый `false` для missing RM;
- защита внутренних `.inc`/template-файлов в Apache-конфигурации;
- синхронная agent-facing и human-facing документация.

## Проверено

- mandatory path/connector/template/asset topology;
- отсутствие full PHP tags и синтаксических конструкций новее PHP 7.2;
- JavaScript source после удаления PHP header проходит `node --check`;
- JSON manifest, все manifest files, related/internal links и Markdown fences;
- отсутствие новых внешних runtime dependencies и high-confidence secrets.

PHP CLI и PHP web server в рабочем окружении отсутствуют. Поэтому `php -l`,
HTTP 200/500, browser rendering и network asset requests имеют статус
**Not run**. Статический результат не объявляется runtime PASS.

Git-релиз этапа: один atomic commit `test: добавить blank/rm smoke (20.0.5)` в
`main` с последующей синхронизацией `origin/main`.
