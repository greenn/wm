# .vmk4/gss3

Status: current structural reference; excluded and runtime unresolved.

`.vmk4` — основной доступный v2 example. `.vmk4/gss3` показывает project IQ,
project RM, pages/router, templates, CSS/images/data и WD presets. Он не
коммитится в WM и не копируется целиком.

## Подтверждённый состав

- project IQ: `.vmk4/gss3/iq.inc`;
- environment/RM manager: `.vmk4/gss3/php/gss3.env.php`;
- 21 matching RM connectors under `.vmk4/gss3/r`;
- 7 pages under `.vmk4/gss3/pages`;
- project handler `.vmk4/gss3/router/mod.php`;
- project images under `.vmk4/gss3/i`;
- project CSS entry tree `.vmk4/gss3/css`;
- WD presets/references under `.vmk4/gss3/wd` and image tree;
- `.vmk4/gss3/test` существует, но snapshot не содержит test files.

Полный список RM components находится в
`aidocs/resources/gss3.md`.

## Почему это не blank

- active `.vmk4/site/web/web[self].inc` ожидает отсутствующий local web;
- `dirSelf` получает absolute path вместо relative path;
- current `iqPro` не раскрывает `css/%sid-css.php`;
- router path и handler context расходятся;
- `pages/.map.inc` отсутствует;
- snapshot не содержит собственные `r/rb` и `r/lay`;
- встречаются stale RM/admin references;
- excluded settings содержат sensitive values и не переносятся.

Product/catalog JSON не читались при составлении карты. До использования
выбрать web mode, исправить contracts отдельными commits и выполнить полный
smoke suite.
