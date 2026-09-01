# blank/rm — минимальный named RM

Status: implemented; static contract checked; PHP/HTTP runtime not run in the
current workstation because no PHP runtime or configured web server is
available.

`blank/rm` — изолированный executable example для проверки v2 resource layer.
Он не является новой project blank-заготовкой и не заменяет `test/` будущего
проекта.

## Entry и bootstrap

```text
/blank/rm/index.php
  -> /blank/rm/iq.inc
  -> /web/web.php
  -> site/v2/iq + site/v2/source.class + site/v2/r/rt.class
  -> _iq::add_pro('blank-rm', ...)
  -> /blank/rm/blank-rm.env.inc
```

`iq.inc` намеренно задаёт framework root как корень текущего WM и создаёт только
`iqPro`. `iqSite`, page router, `wd` и project CSS здесь отключены: они не нужны
для проверки одного RM и добавили бы неподтверждённые зависимости.

## Named RM contract

- public base: `blankRm extends rt`;
- manager: `_blankRm extends _rt`;
- physical root: `_blankRm::rDir()` → `blank/rm/r`;
- class mapping: `demo` → `blankRm_demo`;
- connector: `r/demo/demo.class.inc`;
- template: `blankRmTpl('demo', 'card', $ctx)`;
- CSS/JS: `blankRm('demo', 'registerSources')` → `req_css/req_js` →
  `_source::html_export()`.

The connector filename is required. A directory without
`<component>/<component>.class.inc` is not treated as a component.

## Diagnostics

`index.php` checks six stages:

1. shared Web bootstrap;
2. current `iqPro` and `rMain`;
3. matching component connector;
4. template resolution through RM API;
5. CSS/JS registration through source manager;
6. controlled lookup of a missing component.

The first five are critical. A failed critical stage returns HTTP 500 and a
stable safe code; the technical exception goes to PHP error log. The missing
resource check succeeds only when `_blankRm::req('missing-resource')` returns
`false`. Client JavaScript repeats the DOM check and writes every stage to the
browser console.

## Assets and qv

The component calls:

```php
static::req_css(-20, 'demo', true, false);
static::req_js(20, 'demo', true, false);
```

The fourth argument disables `qv` only for this isolated example. It avoids
turning the first RM smoke into an implicit UV database test. The project smoke
in `wm-0` is responsible for checking the normal UV/qv chain.

## Runtime check

Serve the WM root with PHP 7.2 and `short_open_tag=On`, then open:

```text
/blank/rm/
```

Expected evidence is HTTP 200, six passing cards, `PASS` after JavaScript and
successful requests for `demo.css.php` and `demo.js.php`. The client also reads
the `--blank-rm-asset` CSS sentinel, so a generated `<link>` alone cannot produce
the final PASS. This outcome must not be recorded as passed until the request is
actually executed.
