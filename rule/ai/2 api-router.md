# Root API router

## Назначение

Корневой `api/index.php` принимает HTTP request, загружает project `iq.inc`,
выбирает named RM и component, затем делегирует запрос `rt_api`.

Endpoint компонента разрешается в таком порядке:

    <rm-root>/<component>/api/<route>.<lower-http-method>.inc
    <rm-root>/<component>/api/<route>.inc

Method-specific файл имеет приоритет; общий файл является fallback.

## Request

Router различает обычные form/query данные, raw body для PUT/PATCH/DELETE,
multipart/form-data и JSON. Legacy-поддержка method prefix в URL существует, но
новое API должно использовать реальный HTTP method, если нет отдельного
требования совместимости.

## Требования к endpoint

- component уже зарегистрирован через `<component>.class.inc`;
- route и method разрешены явно;
- вход валидируется до использования;
- authentication/authorization выполняются на сервере;
- ответ имеет устойчивую JSON-структуру и корректный HTTP status;
- debug data доступны только в безопасном локальном режиме;
- секреты, SQL, filesystem paths и необработанные exception не возвращаются;
- изменения данных защищены от CSRF там, где используется cookie/session auth.

Список разрешённых RM в текущем root router ограничен и не должен расширяться
по догадке. Admin API, прямой доступ site RM к БД и вызов site к внутреннему
admin API — допустимые разные схемы; выбор фиксируется для конкретной задачи.
