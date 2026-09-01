# Testing map

Status: policy current; framework root currently has no `test/` directory.

Default location for project smoke tests and URL-accessible dev examples:

    <project-root>/test/

Component-local test is an exception only when it cannot be separated from
private component context.

## Existing test/example trees

These paths are historical/support material, not the default for a new project:

| Path | Status |
|---|---|
| `r/rb/aos/test` | component examples |
| `r/rb/css/flex/test` | component examples |
| `r/rb/mqr/test` | component examples |
| `r/lay/button/test` | component example |
| `r/rb/test` | large legacy/support test tree; `test` is not an rb component |
| `r/rb/vue/test`, `r/rb/vue/tests` | mixed Vue 2/Vue 3 examples |
| `r/rb/vue/re/.../test` | research/vendor example |
| `.blank/test-blank`, `.blank2/test-blank` | blank examples only |
| `.vmk4/gss3/test` | directory exists, contains no tests in snapshot |
| `blank/rm` | targeted v2 named RM smoke; static checked, PHP/HTTP not run |

There is no top-level `.test` project overlay in the inventoried root; similarly
named test directories must be evaluated by exact path.

`blank/rm` is the first committed executable framework smoke, but it checks one
isolated RM contract only. It does not replace the full project matrix in
`smoke-suite.md`.

## Документы

- [smoke-suite.md](smoke-suite.md) — mandatory project matrix.
- [test-writing.md](test-writing.md) — isolation, output and evidence rules.

Тест считается успешным только после реального запуска. Наличие файла или
успешный static read не заменяет runtime result.
