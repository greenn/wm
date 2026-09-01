# Автономный Documentation Site

Дата: 2026-09-01. Версия результата: `20.0.4`.

Этап `=3` создал внутри `man` независимый PHP/Markdown Documentation Site.

## Реализовано

- постоянная навигация, центральная статья и контекстная колонка примеров;
- безопасный manifest-driven Markdown endpoint с whitelist и containment check;
- local syntax highlighting, search, responsive drawer и copy controls;
- human docs для WM, site, admin, RM, PHP/API/assets/testing;
- journal explorer с группировкой записей по страницам и модулям;
- подробные loading, success и error events в browser console;
- отсутствие IQ/RM, Node/build и внешних runtime dependencies.

Карта содержит 29 navigation documents и 13 отдельных aside. Всего внутри
`man` находятся 49 файлов, из них 43 Markdown-файла.

## Проверено

- JSON manifest читается; все 29 ID имеют content и встречаются в navigation
  ровно один раз;
- отсутствуют потерянные aside, related, journal page и internal `doc:` links;
- все Markdown-файлы непустые, code fences сбалансированы;
- exact coverage подтверждена для `rb` 26/26, `lay` 6/6, `gss3` 21/21 и
  семи project pages GSS3;
- `node --check man/assets/app.js` проходит;
- read-only preview успешно выдал manifest и все 29 документов;
- нет external runtime URLs, full PHP tags и high-confidence secrets;
- direct Markdown/manifest access закрыт Apache-конфигурацией.

PHP CLI в рабочем окружении отсутствует, поэтому `php -l` и выполнение на
реальном PHP-сервере здесь не запускались. Read-only preview проверяет контракт
данных и клиент, но не заменяет PHP lint. PHP-файлы оставлены совместимыми с
целевым PHP 7.2 и дополнительно проверены вручную.

Git-релиз этапа: один atomic commit `docs: создать Documentation Site
(20.0.4)` в `main` с последующей синхронизацией `origin/main`.
