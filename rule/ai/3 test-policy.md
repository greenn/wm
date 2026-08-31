# Test policy

## Расположение

Стандартное место тестов и URL-доступных dev examples — project root `test`.
Component-local test допустим только когда тест невозможно осмысленно отделить
от внутреннего component context.

## Минимальный smoke-набор нового проекта

1. `index.php`/bootstrap без fatal error.
2. Base page и обычный page PID.
3. Неизвестный URI с реальным HTTP 404.
4. `is-mod` parent и sub-URI.
5. Redirect с валидированным URI/status.
6. Project router и page shell через `rMain`.
7. Один template каждого задействованного RM.
8. API GET и изменяющий method с auth/error cases.
9. CSS/JS/image/font URL, Content-Type и `qv()`.
10. Vue 3 client route: navigation, back/forward, reload/direct URL.
11. WD preset/reference, если UI сравнивается визуально.

Тесты не читают production credentials, не меняют реальные данные и не зависят
от больших product JSON. Результат фиксирует environment, URL, ожидаемое и
фактическое поведение. Успешным называется только реально выполненный тест.
