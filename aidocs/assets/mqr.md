# MQR

Status: current optional; provider selection/runtime integration needs a
consumer-specific check.

MQR — JavaScript runtime scaler фиксированного блока. Это не CSS media queries
и не замена обычной responsive layout.

## Entry и механизм

- RM connector: `r/rb/mqr/mqr.class.inc`;
- CSS wrapper: `r/rb/mqr/mqr.css.php`;
- current candidate provider: `r/rb/mqr/provider/v2/mqr.js.inc`;
- init: `provider/v2/initMQAutoResize.js.inc`;
- resize: `provider/v2/MQAutoResize.js.inc`.

Provider:

1. находит `[mqr]`;
2. пропускает nested/уже wrapped nodes;
3. оборачивает node в `.mqr-w`;
4. вычисляет scale и `transform-origin`;
5. задаёт wrapper dimensions и служебный `scaled` attribute.

Подтверждённые option attributes: `mqr`, `mqrc`, `mqrs`, `mqrw`, `mqrk`,
`mqrz`, `mqrh`, `mqrl`. PHP helpers `a_mqr()` и `a_mqr_byCtx()` формируют
основной attribute.

## Dependencies и риски

V2 provider использует jQuery, Lodash и `_vue.provider`. Текущий code assigns
`window.onresize` напрямую и при вычислении использует `screen.width`; это
может конфликтовать с другими resize handlers/viewport behavior. Поэтому
точный provider и consumer проверяются до use.

Применять только для масштабирования целого фиксированного макета/widget.
Проверять nested nodes, resize, transform origin, pointer hit areas, text,
disabled JS и обычный layout без scale.
