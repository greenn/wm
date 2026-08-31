# .vmk4/gss3 как current-пример

## Роль

`.vmk4/gss3` — основной доступный пример project v2 с `iqSite`, `iqPro`,
project RM, pages, router, templates и assets. Это источник наблюдений, но пока
не готовый рабочий blank.

Инвентаризация без чтения содержимого product JSON показала:

- 21 project RM component, каждый с `<name>.class.inc`;
- 60 templates;
- 7 page files: `404`, `agent`, `catalog`, `contacts`, `docs`,
  `index`, `service`;
- 255 PHP/INC файлов проходят lint в PHP 7.2.34 с `short_open_tag=On`.

Project-owned части: `iq.inc`, entry point, `pages`, `router`, `r`,
`css`, images/data и другие нужные assets. Project RM gss3 хранит
project-specific components и page/template data; basic site RM остаётся
отдельным слоем.

## Статус

Структура полезна для подготовки `aidocs`, но bootstrap и несколько contracts
расходятся с current implementation. Полный список находится в
`4 known-issues.md`.

Нельзя:

- копировать проект целиком;
- читать product/catalog JSON ради общей документации;
- переносить settings/credentials;
- считать отсутствующие `.map.inc`, local `web`, `r/rb`, `r/lay`
  необязательными без проверки;
- исправлять найденные проблемы в рамках этапа `=1`.
