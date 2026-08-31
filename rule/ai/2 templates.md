# Templates

Template — представление, которое вызывается в контексте конкретного RM
component. Он не является самостоятельным component без собственного
`<component>.class.inc`.

Типовая цепочка:

    named RM helper
      -> component connector/class
      -> tpl(<name>, <context>)
      -> output buffering
      -> HTML/CSS/JS fragment

Правила:

- вызывать template через существующий RM helper, а не собирать внешний
  filesystem path вручную;
- передавать явный минимальный context;
- defaults задавать локально и не скрывать обязательные значения;
- экранировать данные в соответствии с HTML/attribute/URL/JS контекстом;
- держать component-specific templates, CSS, JS и Vue fragments рядом;
- не считать подпапки template самостоятельными components;
- новые PHP templates совместимы с PHP 7.2 и используют короткие теги;
- Vue fragments для нового кода соответствуют Vue 3.

Для каждого template документировать owner component, имя вызова, context,
выход, вложенные templates/resources и страницы-потребители. Прямой include
допустим только если текущий contract именно так устроен.
