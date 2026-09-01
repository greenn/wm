# Компоненты и templates сайта

Page shell собирается из named RM. Для project `gss3` оболочку дают `page`,
`header`, `footer`, `menu`, `logo` и связанные components; `rb` предоставляет
общие page/router/assets primitives; `lay` — повторно используемые элементы
компоновки.

## Connector сначала

```text
gss3/r/header/header.class.inc
  -> class gss3_header
  -> templates / CSS / JS / Vue / API
```

Каталог `header/templates` без `header.class.inc` не образует component.
Support classes вроде `catalog-data.class.inc` остаются частью `catalog`.

## Две стадии render

```text
content component template
  -> project page/page
  -> project page/html
```

`rMain` выбирает RM page shell. Template получает минимальный явный context и
возвращает HTML через output buffering. Значения экранируются по HTML,
attribute, URL или JavaScript context.

## Группы GSS3

| Группа | Components |
|---|---|
| Оболочка | `page`, `header`, `footer`, `logo`, `menu`, `top-menu` |
| Контент | `content`, `banner`, `contacts`, `info`, `catalog`, `plan`, `marquee` |
| App/UI | `app`, `ui`, `search`, `sys-msg`, `uc` |
| Support | `addresses`, `css`, `blank` |

При переносе страницы перечисляют owner RM, component, точный template,
обязательный context, assets и API. Project-specific section не переносится в
`rb` или `lay` только ради удаления одного повтора.
