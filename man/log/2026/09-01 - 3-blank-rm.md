# Задание 3: минимальный `blank/rm`

Дата: 2026-09-01. Этап владельца: `=4`. Планируемая версия результата:
`20.0.5`.

## Цель и границы

Создать внутри WM минимальный исполняемый named RM, доступный через
`blank/rm/index.php`, и проверить на одном component фактическое понимание v2
IQ, resource connector, template API и source manager.

В эту атомарную подзадачу не входят новый project skeleton, full page router,
Vue Router, API и UV/qv. Они относятся к следующему этапу `=5`.

## Обязательные решения

- PHP 7.2 и только short open tags в новых PHP-файлах;
- component существует через точный `<component>.class.inc`;
- template разрешается RM API, а не ручным физическим include страницы;
- CSS/JS подключаются через source mechanism;
- каждый серверный и клиентский этап получает понятный диагностический сигнал;
- отсутствие ресурса обрабатывается как ожидаемый контролируемый результат;
- никаких новых package/build/runtime dependencies.

## План атомарной подзадачи

1. Создать изолированный `iqPro` и named RM `blankRm`.
2. Зарегистрировать component `demo` matching connector.
3. Добавить template и CSS/JS endpoints через component API.
4. Собрать diagnostic page с HTTP 500 для критического contract failure.
5. Обновить `aidocs`, Documentation Site, журнал и PATCH-версию.
6. Выполнить доступные static checks; PHP/HTTP запускать только при наличии
   локального runtime.

## Критерии готовности

- все обязательные файлы и точные connector/template/asset пути существуют;
- source export содержит оба component asset URL;
- missing component не подменяется фиктивным resource;
- PHP surface не использует конструкции новее PHP 7.2;
- JavaScript синтаксически корректен;
- Documentation Site manifest и internal links согласованы;
- реальный runtime результат отделён от статической проверки.

Ожидаемое Git-влияние: один atomic commit в `main`, PATCH `20.0.5`, push в
`origin/main`.
