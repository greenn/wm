# WM: инструкции для Codex

Этот файл действует для всего репозитория. Более вложенный `AGENTS.md` может
уточнить правила своего проекта, но не отменяет ограничения владельца.

## Перед работой

1. Прочитай текущий запрос, `rule/ai/0 owner-decisions.md` и
   [карту aidocs](aidocs/README.md).
2. Проверь `git status`, текущий `VERSION.json` и локальный `AGENTS.md`
   целевого проекта.
3. Исследуй только связанные с задачей файлы. Сначала current v2, затем точечный
   legacy/reference.

Приоритет внутри материалов WM: прямой запрос владельца → owner decisions →
`rule/ai` → current code → legacy/reference. System/developer instructions
среды всегда выше.

## Runtime и стиль

- Новый PHP совместим с 7.2, `short_open_tag=On`, использует `<?`/`<?=`.
- Новый frontend — Vue 3. Vue 2 только legacy.
- Не добавляй npm/build pipeline, framework или dependency без прямой
  необходимости.
- Новые files/directories/CSS/images — kebab-case; PHP/JS variables —
  camelCase; крупные сущности могут быть PascalCase. Legacy не переименовывай.
- Сохраняй простой минимальный diff. DRY прагматичный: не рефактори самовольно,
  небольшой осознанный повтор допустим.
- Для значимых browser-этапов и ошибок оставляй безопасный `console.log`;
  неочевидным действиям давай title/tooltip.

## Архитектурные инварианты

- `r` — resource layer, не один RM. `rb`, `lay`, `site`, `admin`,
  project RM — разные named RM и могут находиться в разных roots.
- RM component существует только с
  `<component>/<component>.class.inc`. Template/support directory без
  connector не является component.
- IQ connector, library connector и RM connector не смешиваются:
  `<project>/iq.inc`; `web/lib/<name>/<name>.php` + `_lib('<name>')`;
  `<component>.class.inc`.
- Для новых pages каноничен v2. PHP-router выбирает server page; `vue-router`
  управляет client history, не заменяя direct URL/reload fallback.
- Root API ищет `api/<route>.<method>.inc`, затем
  `api/<route>.inc`. Server auth/ACL обязателен.
- Canonical URL-version directory — `site/uv`; cache busting — через `qv()`.

## Границы и данные

- Никогда не читай/не ищи внутри `rule/dd/-` и `rule/ai-`.
- Dot-projects читаются только точечно и не коммитятся. `.blank`/`.blank2`
  — коммитируемые заготовки, но не гарантированно рабочий runtime.
- Не сканируй и не выгружай product/catalog/content JSON без прямой
  необходимости. Не копируй settings, credentials, tokens и customer data.
- Не меняй legacy, blanks или найденные implementation gaps без связи с задачей.

## Изменение и проверка

1. Найди реальный entry point, definitions и consumers через `rg`.
2. Проверь соседний current-код и соответствующий раздел `aidocs`.
3. Измени минимально необходимое.
4. Выполни пропорциональную проверку: PHP lint с short tags, целевой URL/API,
   root `test`, asset loading или visual compare через `wd`.
5. Обнови относящиеся `aidocs`; human docs после их появления — в `man/wm`.
   Идеи вне scope только в `man/sug`, без реализации до approval.

## Version и Git

- Источник версии — `VERSION.json`; версия `web` в `web/web.php` отдельна.
- Один атомарный commit повышает PATCH на 1 и синхронизирует отображаемую версию.
- Не повышай версию при read-only анализе без repository changes.
- Не трогай чужие staged/unstaged/untracked changes.
- Если владелец не указал иное: scoped checks → atomic commit → push в
  `main`, без PR и без force/history rewrite.

Подробная карта: [aidocs/README.md](aidocs/README.md).
