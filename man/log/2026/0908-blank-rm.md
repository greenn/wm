# Этап =4: blank/rm в astra-high

Дата: 2026-09-08. Версия: 20.0.5. База: `82a7f9034332df08c4c57e7061cce6b0769ed9fa`.

По указанию владельца ветка `astra-high`, первоначально созданная от `6f10d41`,
удалена без изменений и создана заново от `82a7f90`. В ней выполнена отдельная
реализация `=4`: IQ v2, named RM, один обязательный connector, template через
RM API, static CSS/JS через source manager и диагностическая страница.

План атомарной работы: проверить v2 contracts, реализовать изолированный RM,
проверить HTTP/browser и отказы, обновить документацию и PATCH, commit/push
в запрошенную ветку.

## Фактическая проверка

- PHP 7.2.34 из OpenServer, short tags: lint пяти PHP/inc — PASS.
- JavaScript: `node --check` — PASS.
- `/blank/rm/index.php` и `/blank/rm/`: HTTP 200, шесть true — PASS.
- CSS: HTTP 200, `text/css`; JS: HTTP 200, `application/javascript` — PASS.
- Browser: CSS sentinel, template DOM, итог PASS, console events, кнопка — PASS.
- Desktop и 390×844: читаемая раскладка, без горизонтального overflow — PASS.
- HTML в title экранирован, missing template возвращает пустую строку — PASS.
- Missing resource: `req()` и `name()` возвращают false — PASS.
- Поочерёдно убраны connector, template, CSS, JS: контролируемый HTTP 500,
  без PHP warning/fatal/path в ответе; все файлы восстановлены, HTTP 200 — PASS.
- Apache `.htaccess`: not run; проверка на встроенном PHP server.

Визуальные свидетельства находятся в `man/wm/blank-rm/desktop.png` и
`man/wm/blank-rm/mobile.png`. Human guide и agent map описывают точные contracts
и воспроизводимый запуск. Shared web, legacy и dot-projects не изменены.

Связанные страницы: [RM-тест](doc:wm/blank-rm), [тестирование](doc:reference/testing).
