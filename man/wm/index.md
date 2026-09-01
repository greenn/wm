# WM за 10 минут

WM — общий PHP-фреймворк и ресурсная база для сайтов и приложений. Он даёт
bootstrap, loaders, страницы, ресурсные менеджеры и browser-assets, но не
подменяет конкретный проект.

> [!NOTE] Current contract
> Новый код строится на v2, PHP 7.2 с `short_open_tag=On` и Vue 3. Vue 2 и
> pages v1 остаются только для сопровождения legacy.

## Где проходит граница проекта

Проект владеет `index.php`, `iq.inc`, корневым `test/`, собственным RM,
страницами, router-handlers и нужными assets. Общий `web` предоставляет PHP
runtime и libraries; `rb` и `lay` образуют стандартную resource-базу.

```text
HTTP request
  -> project entry + IQ
  -> shared/local web
  -> page router
  -> named RM component
  -> template + assets
  -> response
```

## Resource layer и RM

Каталог `r` — слой ресурсов, а не единый RM. `rb`, `lay`, `site`, `admin` и
project RM — отдельные именованные менеджеры. Компонент существует только при
наличии точного connector-файла:

```text
<rm-root>/<component>/<component>.class.inc
```

Template, data или test directory без такого connector остаётся частью
владельца либо support-каталогом.

## Три connector-контракта

| Механизм | Entry | Задача |
|---|---|---|
| IQ | `<project>/iq.inc` | Подключить окружение сайта или проекта. |
| Library | `web/lib/<name>/<name>.php` | Загрузить библиотеку через `_lib('<name>')`. |
| RM component | `<component>.class.inc` | Зарегистрировать component в named RM. |

Эти механизмы нельзя заменять друг другом. Дальнейшие разделы показывают один
канонический путь, а подтверждённые расхождения помечают как `legacy` или
`unresolved`.
