# `web`: framework bootstrap и режимы подключения

## Bootstrap

Главный connector framework:

```text
web/web.php
```

Он определяет `ROOT`, `WEB`, `PHP`, `LIB`, `INC`, сведения о host/URI и подключает `web/php/need.php`. Версия `web` хранится в комментарии первой строки `web.php`; её нельзя автоматически приравнивать к версии WM.

Текущий целевой runtime — PHP 7.2, `short_open_tag=On`.

## Режим 1: local web

Файл проекта:

```text
site/web/web[self].inc
```

подключает:

```text
<DOCUMENT_ROOT>/web/web.php
```

Этот режим требует локальной папки `web` внутри document root. Проверять надо не только connector, но и фактический target.

## Режим 2: centralized/shared web

Владелец использует для локальных и собственных доменов централизованный
`web`, который не копируется в каждый project. Host-specific выбор начинается
в настройке:

```text
site/settings/settings[<domain>].inc
```

Эта настройка должна однозначно задать/подключить реальное расположение общего
`web/web.php` через действующую connector-цепочку проекта. Точный набор
переменных нельзя придумывать: его надо проверить по безопасной структуре
конкретного settings-файла, не выводя значения credentials.

Файлы вида `site/web/web[<host>].inc` встречаются в исторических вариантах и
могут быть частью фактической цепочки, но не заменяют подтверждённую владельцем
host-specific настройку в `site/settings`. Одновременный активный
`web[self].inc`, указывающий на отсутствующий local `web`, нельзя считать
рабочим shared mode.

## Что обязан проверить Codex

- `DOCUMENT_ROOT` и физический target выбранного connector-а;
- какой режим реально выбран: local self либо host-specific settings/shared;
- наличие `web.php` и корректность его первой строки/version comment;
- что `ROOT` остаётся root проекта, даже если `WEB` находится в соседней общей папке;
- доступность `ROOT/r/rb` и `ROOT/r/lay`: shared `WEB` не перенаправляет resource roots автоматически;
- загрузку `_needphp()`, v2 IQ, router/pages/resource classes;
- отсутствие случайного fallback на legacy framework.

## Текущее состояние `.vmk4`

Активный `.vmk4/site/web/web[self].inc` ожидает `.vmk4/web/web.php`, но такой файл в snapshot отсутствует. Соседний `J:/dv/wm/web/web.php` автоматически не используется. Это блокирует bootstrap и должно быть исправлено выбранным режимом до первого рабочего запуска.

## Запреты

- Не угадывать shared path из имени host.
- Не копировать `web` автоматически, пока режим не выбран.
- Не менять версию `web` вслед за версией WM.
- Не редактировать legacy connector, если он не участвует в активной цепочке.
