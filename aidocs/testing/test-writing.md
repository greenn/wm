# Правила написания тестов

Status: current.

## Размещение

- Новый URL test: `<project-root>/test/<kebab-name>.php`.
- Shared fixture/helper держать внутри root `test`, если он не является
  production API.
- Component-local test допустим только для private/internal context, который
  невозможно корректно вызвать из root test.
- Не добавлять новый test в historical `r/rb/test` или Vue research tree.

Новый PHP test совместим с PHP 7.2, требует `short_open_tag=On` и использует
short tags framework.

## Isolation

- Никаких production credentials, sessions, tokens или real customer data.
- Read-only test по умолчанию.
- Mutation использует disposable fixture и явный cleanup/recovery.
- Не зависеть от больших catalog/product JSON.
- Не делать network request к внешнему service без отдельного разрешения и
  безопасной fixture strategy.

## Assertions и output

Для HTTP test проверять status, headers/Content-Type и body contract. Для
template — owner RM, exact template name, minimal context и escaped output. Для
asset — URL, status, Content-Type и UV query. Для browser UI — observable state,
route/reload и screenshot/WD evidence по необходимости.

`console.log` разрешён по умолчанию, но test не должен выводить secrets.
Warnings/notices в generated CSS/JS/JSON считаются failure.

## Результат

Запись результата должна отличать:

- `pass` — реально выполнено и совпало;
- `fail` — реально выполнено и не совпало;
- `blocked` — запуск невозможен с указанной причиной;
- `not run` — только подготовлено/проанализировано.

Не заменять `not run` словом «проверено».
