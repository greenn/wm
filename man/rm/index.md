# Resource Managers

Named RM связывает manager, физический root, components и короткие public
helpers. `r` — общий resource layer, а не один RM.

## Contract component

```text
<rm-root>/<name>/<name>.class.inc
```

Connector регистрирует component class и config. После регистрации component
может предоставлять PHP methods, templates, calls, CSS, JS, Vue pairs, images,
data и API endpoints.

## Типичная цепочка

```text
rb_tpl('page', 'page', $ctx)
  -> _rb::req('page')
  -> r/rb/page/page.class.inc
  -> rb_page
  -> page.tpl.php
```

Template directory или support class без matching connector не становятся
самостоятельным component.

## Named RM WM

| RM | Роль | Matching components |
|---|---|---|
| `rb` | Базовые ресурсы framework | 26 matching connectors |
| `lay` | Повторно используемый layout | 6 connectors |
| `blankRm` | Минимальный executable v2 test | 1 connector (`demo`) |
| `site` | Целевой basic site RM | 0 current v2 — gap |
| `admin` | Целевой admin RM | 0 committed root — gap |
| `gss3` | Project RM structural example | 21 connectors |

Новый RM получает manager, base class, `rDir()`, `className()` и named helpers.
Общий component переносится в shared RM только после подтверждённых consumers.

Практическая минимальная реализация разобрана в
[первом исполняемом RM-тесте](doc:rm/blank-rm).
