# Project smoke suite

Status: current required baseline.

| # | Сценарий | Минимальное ожидаемое |
|---|---|---|
| 1 | Bootstrap/`index.php` | HTTP response без fatal/warning; корректные current site/project, `ROOT`, shared/local web. |
| 2 | Base page | Base PID рендерит project page shell через подтверждённый `rMain`. |
| 3 | Normal page | Exact PID загружает page data, handler и templates. |
| 4 | Unknown URI | Реальный HTTP 404, не только HTML «404». |
| 5 | `is-mod` | Longest parent принимает sub-URI и получает корректный context. |
| 6 | Redirect | URI и status валидированы; нет open redirect/loop. |
| 7 | Project router | Custom handler получает ожидаемые keys/types и не удваивает router path. |
| 8 | RM templates | По одному реальному template каждого используемого `rb`, `lay` и project RM. |
| 9 | API GET | Success/error/status/content-type; route → `<route>.get.inc` или fallback. |
| 10 | API mutation | Auth/ACL, validation, CSRF при cookie/session auth, error и recovery. |
| 11 | CSS/JS | HTTP 200, correct Content-Type/order, no PHP warning, `qv()` updates. |
| 12 | Image/font | URL, dimensions/alt or font face, Content-Type/CORS/fallback. |
| 13 | Vue 3 route | Navigation, loading/error, back/forward, direct URL и reload через PHP entry. |
| 14 | WD | Preset/reference/live at fixed viewport, если UI сравнивается. |
| 15 | MQR | Только если используется: resize, nested nodes, pointer areas, disabled JS. |

## Environment header

Каждый результат фиксирует:

- project root и Git revision;
- PHP version (target 7.2) и `short_open_tag=On`;
- host/URL, local/shared web mode;
- site/project sid и `rMain`;
- browser/viewport для UI;
- test data source без credentials;
- expected, actual, status и evidence.

Секретные settings values не печатаются. Product JSON не нужен для baseline
smoke; использовать минимальные fixtures.
