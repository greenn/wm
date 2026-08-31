# Named RM `lay`

## Роль и расположение

`lay` — именованный RM повторно используемых layout/primitives. Его v2 manager находится в `web/php/site/v2/r/lay.class.php`, а ресурсный root по текущему contract:

```text
<ROOT>/r/lay
```

Public helpers:

```php
<?
_lay::req('button');
$html = lay_tpl('button', 'button', $ctx);
$value = lay('button', 'method', $arg);
```

Текущие подтверждённые components:

```text
blank, button, flex, menu, pic, text
```

У каждого есть `<component>.class.inc`.

## Особенность templates

`lay::tpl()` сначала проверяет форму `<name>/<name>.tpl.php`. Если такой template существует, используется она; иначе действует обычное разрешение template path. Не имитировать эту особенность вручную в project RM.

## Обязательность

`lay` не является обязательной runtime-зависимостью каждой страницы. Однако владелец включил `r/lay` в канонический комплект нового проекта, потому что текущие компоненты могут ссылаться на него. Убирать `lay` можно только после полного dependency audit, а не по отсутствию одного прямого вызова.

## Не путать

`lay` как named RM и component `rb/lay` — разные сущности и разные namespaces. Физическая близость в `r/` также не превращает `r` в RM.

## Правила расширения

- Общий визуальный primitive может стать component `lay`, если он реально повторно используется.
- Проектная секция/блок остаётся в project RM.
- Новый component получает обязательный connector и локальные templates/styles.
- Не переносить в `lay` код только ради DRY, если это усложняет простое решение.
