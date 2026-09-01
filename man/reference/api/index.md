# Root API и component endpoints

Root API направляет HTTP request в API владельца RM component. HTTP method
входит в разрешение endpoint.

```text
METHOD /api/<rm>/<component>/<route>
  -> api/.htaccess
  -> api/index.php
  -> project IQ
  -> RM manager + connector
  -> api/<route>.<method>.inc
     fallback api/<route>.inc
  -> response
```

## Endpoint contract

Method-specific файл имеет приоритет. Fallback `<route>.inc` используется
только осознанно; отсутствие допустимого method должно приводить к 405, а не к
случайному выполнению общего handler.

Endpoint валидирует route segments, content type, payload и method. Он
возвращает JSON с реальным HTTP status и не раскрывает stack trace, SQL,
absolute paths, settings или tokens.

## RM allow-list gap

Current root router содержит список RM prefixes, но его проверка не образует
строгий allow-list перед dynamic manager call. Пример `.vmk4` запрашивает
project RM, которого нет в списке.

> [!UNRESOLVED]
> Перед публикацией endpoint проект задаёт точный allow-list, подтверждает
> manager/connector и возвращает ранний 404/403 для неизвестного RM.

## Security

- Authentication и action-level authorization выполняются server-side.
- Cookie/session mutation защищена от CSRF.
- CORS минимален и не заменяет CSRF.
- Internal PHP helper/token flag не доказывает подлинность внешнего request.
- Debug выключен и внутри endpoint, а не только в root entry.
- Error contract различает 400, 401, 403, 404, 405, 422 и 500.
