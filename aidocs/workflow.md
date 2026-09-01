# Рабочий процесс агента

## Исследование

1. Прочитать `AGENTS.md`, target-local instructions и релевантный
   `rule/ai`.
2. Проверить Git/версию, не смешивать пользовательские изменения.
3. Через `rg` найти entry, definition, calls и consumers.
4. Сначала current v2; legacy/dot-project — только точечное подтверждение.
5. Не читать product JSON/settings/secrets ради архитектурной карты.

## Реализация

1. Зафиксировать owner, слой и public contract изменяемой сущности.
2. Сохранить PHP 7.2/short tags/Vue 3/naming.
3. Не создавать параллельный loader/router/RM.
4. Новый component получает точный `<component>.class.inc`.
5. Тесты по умолчанию — root `test`; component-local только по необходимости.

## Проверка

- PHP: `php -d short_open_tag=1 -l <file>`.
- Routing/API: прямой URL, method, status, 404/redirect и auth/error cases.
- Assets: status, Content-Type, output без warning, `qv()`.
- Vue: mount, API states, route/back/forward/reload.
- UI: target viewport и `wd` reference/live при наличии.
- Git: scoped diff, diff-check, secret/exclusion scan.

## Завершение

Обновить `aidocs` и относящиеся human docs. Идеи вне задачи оформить как
proposal и не внедрять. Для repository change повысить PATCH один раз на
атомарный commit, синхронизировать display version, commit и push `main`, если
владелец не изменил workflow.
