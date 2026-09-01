# Fonts

Status: mixed; часть endpoints current structural, несколько paths unresolved.

Font CSS endpoint и font files считаются одной зависимостью. Перед переносом
проверить license, только реально используемые weights и HTTP behavior.

| Family/entry | Files/root | Status и риск |
|---|---|---|
| Formular — `fonts/formular.css.php` | `fonts/formular/`, eot/ttf/woff/woff2 | unresolved: endpoint объявляет 400 как `Formular-Regular.*`, но snapshot содержит `Formular.*`. Остальные declared Light/Italic/Medium/Bold/Black files присутствуют. |
| JACKPORT COLLEGE NCV — `fonts/jackpot-college-ncv.css.php` | `fonts/jackport-ncv/`, ttf/woff | license review required: есть `PersonalUseEULA_JACKPORT_NCV.txt` и `COPYRIGHT.txt`. Raw/local и external-import variants тоже существуют. |
| NAMU — `fonts/namu.css.php` | `fonts/namu/TTF_WEB`, `OTF_PS`, `Web` | current structural; weights 100, 200, 300, 400, 500, 700, 800, 900. License evidence: `fonts/namu/COPYRIGHT.txt`. |
| NAMU Pro — `fonts/namu-pro.css.php` | те же NAMU roots | current structural, weight 400. |
| NAMU Tryzub — `fonts/namu-tryzub.css.php` | `NAMU-Tryzub` in TTF_WEB/OTF_PS | current structural, weight 400. |
| `fonts/namu-r.css.php` | no face output | unresolved/stub: endpoint выставляет headers, но не объявляет `@font-face`. |
| Netflix (Bebas Neue) — `fonts/netflix-bebas-neue.css.php` | `fonts/netflix-bebas-neue/Netflix-(Bebas-Neue).ttf` | license review required; не переносить без проверки `COPYRIGHT.txt`/source terms. |
| Suisse Intl — `fonts/suisse_intl.css.php` | `fonts/suisse_intl/SuisseIntl-*.otf` | current structural; weights 100–700 and 900, italic variants; distribution rights не подтверждены этой картой. |
| Suisse Intl Book — `fonts/suisse_intl-book.css.php` | Book/BookItalic OTF | current structural, weight 400. |
| Urbanist — `fonts/urbanist.css.php` | actual files under `fonts/urbanist/` | unresolved: endpoint в финальном assignment указывает `/fonts/urbanist3/webfonts`, которого нет. |
| Static Urbanist — `fonts/urbanist.css` | actual files under `fonts/urbanist/transfonter*` | unresolved: CSS absolute URLs начинаются `/urbanist/...`, а repository root — `/fonts/urbanist/...`. |

## Правила добавления

- Предпочитать `woff2`, затем нужный fallback; не копировать все форматы и
  weights «на всякий случай».
- Указывать корректные `font-weight`/`font-style`, fallback stack и
  `font-display`.
- Preload только для реально критичного face.
- URL проходит через действующий cache/UV contract, если endpoint подключается
  source manager.
- License/source фиксируются до commit проекта.

## Smoke

Проверить CSS endpoint: HTTP 200, `text/css`, отсутствие PHP warnings. Затем
проверить каждый фактически объявленный font URL, Content-Type/CORS и computed
font в browser. Unresolved entries выше нельзя объявлять рабочими без такой
проверки.
