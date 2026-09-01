# Skills, hooks, MCP и subagents

Status: **assessment only**. Ничего из перечисленного не включено; внедрение
требует отдельного approval/proposal.

## Сейчас

- Дополнительный MCP не нужен: source of truth локален, достаточно filesystem,
  `rg`, PHP и Git.
- Subagents полезны для независимых read-only inventories и раздельных
  документационных каталогов; общий Git/version остаётся у одного агента.
- Browser control будет полезен на этапах `=3`–`=5` для Documentation Site,
  URL smoke tests и visual compare, но не является dependency WM.

## После стабилизации contracts

1. Skill `wm-rm-component`: создать component только по подтверждённому
   manager/blank, connector + template/assets + root test.
2. Skill `wm-project-bootstrap`: собрать `wm-0` после закрытия IQ/web gaps.
3. Pre-commit hook: scoped PHP 7.2 lint, `git diff --check`, forbidden paths,
   high-confidence secrets и sync `VERSION.json`/display version.
4. Documentation check: broken relative links и component lists только по
   `*.class.inc`.

Skills/scaffold не создавать раньше этапов `=4`/`=5`: текущие blanks и
`.vmk4` имеют unresolved gaps, которые нельзя автоматизировать как канон.
