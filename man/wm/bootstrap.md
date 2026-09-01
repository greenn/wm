# Bootstrap, Web и IQ

IQ соединяет окружение сайта, окружение проекта и общий `web`. Он не является
Resource Manager и не регистрирует components.

## Фактическая root-цепочка

`site/iq.inc` подключает `_webConnector`, который выбирает connector `web`,
загружает `web/web.php`, v2 IQ и managers. После этого регистрируются `iqSite`
и `iqPro`.

```text
site/iq.inc
  -> site/php/_webConnector.class.php
  -> site/web/web[self|host].inc
  -> web/web.php
  -> web/php/need.php
  -> site v2 / IQ / pages / RM
```

`iqSite` хранит host, settings, router и URL-version database. `iqPro` хранит
project paths, pages, router, CSS, WD и project environments.

## Local web

В local mode connector `site/web/web[self].inc` включает
`<DOCUMENT_ROOT>/web/web.php`. Этот режим работает только если проект реально
содержит локальный `web`.

## Централизованный web

Целевой contract владельца выбирает общий `web` через host-specific
`site/settings/settings[<domain>].inc`. В текущем root-коде первичный `web`
подключается раньше, чем `iqSite` читает settings.

> [!UNRESOLVED]
> До отдельного исправления нельзя утверждать, что settings уже способны
> выбрать первоначальный shared web. Для проекта нужно проследить фактический
> connector и не угадывать путь.

## Paths проекта

`selfDir` — абсолютный project root. `dirSelf` — путь относительно
`DOCUMENT_ROOT`. Их нельзя заменять друг другом. Перед запуском проекта
проверяют `pagesDir`, `routerDir`, `wdDir`, CSS path и `rMain`.

Current `iqPro` имеет два известных расхождения: `dirSelf` отсутствует в списке
direct-assignment, а literal `css/%sid-css.php` не интерполируется. Пример
`.vmk4/gss3` поэтому используется как structural reference, а не готовый blank.
