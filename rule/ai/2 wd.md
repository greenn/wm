# WD: визуальная сверка

`wd` — часто используемый dev-инструмент для сравнения эталонного изображения
с живой реализацией страницы/component.

Основная модель:

    project wd preset
      -> reference image
      -> live embodiment
      -> overlay / opacity / outline controls

Project presets находятся в `cur('wdDir')` и читаются как
`<wdDir>/<name>.inc`. Если preset отсутствует, current component может
использовать одноимённый PNG как базовый reference. UI/templates находятся в
`r/rb/wd`.

WD нужен для:

- проверки размеров, отступов и alignment;
- сравнения reference/live через прозрачность;
- контуров и быстрых визуальных переключателей;
- воспроизводимого просмотра конкретного viewport/state.

WD является dev-механизмом и не должен случайно включаться в production.
Reference images и presets не содержат приватные данные. В документации
фиксировать URL, viewport, preset, источник reference, состояние данных и
визуальные расхождения.
