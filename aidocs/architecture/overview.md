# Архитектура WM

Status: **current** с отдельно отмеченными unresolved gaps.

## Роли каталогов

```text
web/             framework bootstrap, PHP helpers и libraries
r/               физическая зона части named RM; сам каталог не RM
  rb/            базовый named RM
  lay/           layout named RM
site/            site IQ, settings, router, static и canonical uv
api/             root HTTP API entry/router
admin/, kot/     административные реализации; проверять конкретный project
.blank*/         коммитируемые заготовки
.vmk4/ и другие  точечные reference projects, не часть Git WM
rule/ai/         обязательные нормализованные задания/решения
aidocs/          agent-first contracts
```

WM — ресурсная база, а не один готовый сайт. Новый project владеет своими
`iq.inc`, `index.php`, root `test`, project RM/pages/router/templates и
нужными assets.

## Server request flow

```text
HTTP URL
  -> public file либо .htaccess rewrite
  -> project/site entry PHP
  -> project iq.inc / site/iq.inc
  -> web/web.php + need loader + v2 IQ
  -> iqSite + iqPro
  -> pages v2 / root API / admin entry
  -> named RM component
  -> handler/template/asset response
```

Точный rewrite и handler выбираются по target project. Root WM не является
доказательством работоспособности dot-project.

## Resource flow

```text
named helper/dispatcher
  -> manager конкретного RM
  -> <rm-root>/<component>/<component>.class.inc
  -> registered component class
  -> method / call include / template / CSS-JS-Vue / component API
```

`rw`/`_rw` дают общую механику. `rb`, `lay` и project managers задают
свои `rDir()`, helpers и base class. Физическая директория без точного
connector не является component.

## Главные границы

- Site environment `site()` (IQ) и planned/current named RM `site` — разные
  уровни.
- `_i($projectSid, ...)` вызывает project image environment; `_i::...` —
  static helper `ROOT/i`.
- PHP-router отвечает за initial/direct request; Vue 3 router — за client
  transitions/history.
- `VERSION.json` версионирует WM; первая строка `web/web.php` —
  отдельный web framework.
