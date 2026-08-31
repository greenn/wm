# .blank и .blank2

`.blank` и `.blank2` сохраняются в Git как стартовые структуры. Они
подтверждают желаемый состав, но не гарантируют рабочий runtime.

Перед использованием:

1. сравнить с current v2 и `.vmk4/gss3`;
2. проверить `iq.inc`, web mode, paths и settings placeholders;
3. проверить наличие обязательных component connectors;
4. убрать только заведомо project-specific/secret values;
5. выполнить PHP 7.2 lint с short tags;
6. запустить smoke tests из `3 test-policy.md`.

Ремонт самих blanks выполняется отдельным этапом/commit, а не скрыто во время
создания документации. Содержимое `test-blank` и соседних примеров не означает,
что component-local tests становятся новым default: default остаётся root
`test`.
