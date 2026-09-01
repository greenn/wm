# WD — visual reference/live comparison

Status: current dev tool; некоторые alternate entries legacy/project-specific.

## URL flow

`wd/.htaccess` переписывает любой path под `/wd/` в `wd/index.php`.
Entry:

    /wd/<preset-name>
      -> wd/index.php
      -> rb('wd', 'preset_ctx', <preset-name>)
      -> rb_tpl('wd', 'wd', $ctx)
      -> <project page shell through rMain>

`rb_wd::getPreset()` читает
`cur('wdDir').'/<preset-name>.inc'`. Если preset отсутствует,
`preset_ctx()` создаёт fallback с `img = '<preset-name>.png'`.

## Implementation

- component: `r/rb/wd/wd.class.inc`;
- main template: `r/rb/wd/wd.tpl.php`;
- UI command sources: `r/rb/wd/cmd.css.php`, `r/rb/wd/js/cmd`;
- variants: `r/rb/wd/v1`, `v1b`, `v1c`;
- project URL entry: `wd/index.php`;
- query `embody` or `res` включает «только embodiment».

Reference image разрешается через project image env. В `gss3` convention
соответствует `gss3/i/wd`.

`wd/page.php` использует legacy `site_tpl()`, а `wd/vue.php` жёстко связан с
`kot`; они не являются default v2 flow.

## Назначение

- reference/live overlay;
- opacity и shade;
- outlines/hoverable regions;
- проверка viewport, размеров, отступов и alignment.

WD — dev-only. Presets/references не должны содержать private data и не должны
самопроизвольно включаться в production.

Для воспроизводимого результата фиксировать URL, viewport, preset, reference
source, state данных и список визуальных расхождений.
