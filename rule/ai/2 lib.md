# Libraries и `_lib()`

## Contract

Library connector отличается от IQ и RM connector-а. Для библиотеки `<name>` канонический entry:

```text
web/lib/<name>/<name>.php
```

Подключение:

```php
<? _lib('<name>'); ?>
```

`_lib()` определён в `web/php/need.php` и делегирует `need::lib()`. `need::lib()` строит точный path `<LIB>/<name>/<name>.php` и выполняет tracked `include_once`.

Текущие примеры contract-а:

```text
web/lib/kint/kint.php
web/lib/mobile-detect/mobile-detect.php
```

## Структура библиотеки

Entry `<name>.php` может подключать vendor, classes, assets и локальные support-файлы своей библиотеки. Наличие `vendor/` или произвольной директории без entry не образует новый library connector.

## Добавление новой библиотеки

1. Проверить, нет ли уже подходящей библиотеки или PHP-function.
2. Создать/поместить библиотеку в `web/lib/<kebab-name>/`.
3. Обеспечить точный entry `web/lib/<kebab-name>/<kebab-name>.php`.
4. Подключать через `_lib('<kebab-name>')` только в потребителе, которому она нужна.
5. Зафиксировать назначение, upstream/version/license, public API и consumers в документации.
6. Не делать библиотеку глобальной обязательной зависимостью без решения владельца.

## Нельзя

- Подменять `_lib()` вызовом `_needphp()`.
- Считать `web/php/<name>.php` library connector-ом.
- Считать `<component>.class.inc` библиотекой.
- Переименовывать существующую legacy-библиотеку ради kebab-case.
- Обновлять vendor или библиотеку без отдельной задачи и проверки PHP 7.2.
