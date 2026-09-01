# Архитектура WM

WM разделяет общий framework, окружение сайта и прикладной проект. Это
позволяет нескольким проектам использовать один `web`, но оставляет страницы,
данные и project RM у их владельца.

## Request flow

```text
HTTP URL
  -> public file или project rewrite
  -> index.php / site/router.php / api/index.php / admin/index.php
  -> project iq.inc + site IQ
  -> shared или local web
  -> iqSite + iqPro
  -> page router / API / admin shell
  -> named RM component
  -> template + CSS/JS/Vue/images
  -> response
```

PHP-router остаётся владельцем initial request, прямого URL и reload. Если
внутри страницы запущено Vue-приложение, `vue-router` отвечает только за
client transitions и browser history.

## Кто чем владеет

| Слой | Владеет |
|---|---|
| `web/` | Bootstrap, PHP helpers, v2 classes и libraries. |
| `site/` | Site IQ, host settings, router, static support и `uv`. |
| `r/rb`, `r/lay` | Общие named RM, копируемые в проект. |
| Project | `index.php`, `iq.inc`, `test/`, project RM, pages и assets. |
| `man/` | Независимая human-документация. |
| `aidocs/` | Точная agent-first карта source contracts. |

Project-specific markup и data не следует переносить в общий RM только ради
формального DRY. Общий слой появляется после подтверждённого повторного
использования и ясного owner.

## Resource flow

Named helper вызывает manager конкретного RM. Manager строит путь к connector,
регистрирует component и только затем вызывает method или template.

```text
rb_tpl('page', 'page', $ctx)
  -> _rb manager
  -> r/rb/page/page.class.inc
  -> rb_page
  -> page.tpl.php
```

> [!WARNING]
> Физическая директория без matching `<component>.class.inc` не является
> component. IQ connector и PHP library connector тоже не заменяют RM entry.

## Две версии

`VERSION.json` относится ко всему WM. Первая строка `web/web.php` фиксирует
отдельную версию общего `web`. Обновление документации или resource-корпуса WM
не должно автоматически менять версию `web`.
