# Dot-project overlays

Status: legacy/current examples depending on project; always excluded from WM
commits.

Известные overlays:

    .vmk4
    .ash
    .gss1
    .ripr
    .kp
    .kp2
    .zo
    .tosno

Политика:

- читать точечно только по текущему contract;
- current v2 и решения владельца выше по приоритету;
- не добавлять overlay files в Git WM;
- не исправлять найденные project problems попутно;
- product/catalog JSON сначала учитывать только по paths/counts;
- settings, tokens, credentials, personal data и dumps не выводить;
- предпочитать один подходящий example массовому обходу всех projects.

`.blank` и `.blank2` — отдельное исключение: это committed templates, а не
external overlays.

Запрещённые области `rule/dd/-` и `rule/ai-` не являются project examples:
их нельзя читать, искать внутри или изменять.
