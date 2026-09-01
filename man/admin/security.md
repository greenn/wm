# Безопасность admin

Admin UI — не security boundary. Все защищённые решения повторяются на
сервере, включая action-level authorization для mutations.

## Обязательный checklist

- PHP проверяет authentication до выдачи private shell/data.
- Guest получает согласованный 401 или login redirect.
- Пользователь без права получает 403.
- Каждый mutation endpoint проверяет конкретное action permission.
- Cookie/session mutation защищена от CSRF.
- Session cookie использует согласованные `Secure`, `HttpOnly`, `SameSite`.
- Payload, route segments и HTTP method валидируются.
- CORS минимален; credentials не сочетаются с wildcard origin.
- Login/return URL не допускает open redirect.
- Bundle, response и logs не содержат settings, SQL, paths и tokens.

## API boundary

Admin frontend обращается к server endpoint, а не читает settings или БД
напрямую. После явной регистрации RM endpoint имеет форму:

```text
/api/admin/<component>/<route>
```

Root API сначала ищет `<route>.<method>.inc`, затем `<route>.inc`. Наличие
строки `admin` в allow-list ещё не подтверждает рабочий manager, connector или
authorization.

## Smoke roles

Проверяют guest, authenticated user, insufficient role и admin для `/admin`,
deep URL, reload, logout, unknown route и каждого mutation endpoint. Успех UI
без этих HTTP cases не считается проверкой безопасности.
