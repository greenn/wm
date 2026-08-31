# Терминология WM

| Термин | Значение |
|---|---|
| WM | Репозиторий фреймворка и общая ресурсная база `J:\dv\wm`. |
| project | Отдельный сайт/приложение со своими `iq.inc`, `index.php`, `test` и project RM. |
| resource layer / `r` | Механика регистрации, поиска, вызова и шаблонизации ресурсов; не один общий RM. |
| RM | Именованный Resource Module/Manager: `rb`, `lay`, `site`, `admin`, `gss3` и другие. |
| component | Каталог RM с обязательным `<component>.class.inc`. |
| template | Представление внутри компонента/RM; само наличие template-каталога не создаёт component. |
| IQ | Connector окружения сайта/проекта (`iqSite`, `iqPro`), не RM connector. |
| library connector | `web/lib/<name>/<name>.php`, подключаемый через `_lib('<name>')`. |
| RM connector | Обязательный `<component>.class.inc`, регистрирующий component в named RM. |
| site environment | Host/settings/router/pages/uv context через `iqSite`; не смешивать с named RM `site`. |
| v2 pages | Каноническая для нового кода серверная page/router-система. |
| PHP-router | Выбирает серверную страницу, данные, handler и initial HTML. |
| vue-router | Клиентская история Vue-приложения; не заменяет server routing. |
| `wd` | Инструмент визуального сравнения reference image и live implementation. |
| `mqr` | Необязательный JS runtime scaler по атрибуту `[mqr]`; не CSS media query. |
| `uv` | База URL-версий для cache busting; канонически хранится в `site/uv`. |
| `wb` / WebBuilder | Пока только placeholder будущего приложения, без утверждённого API. |
| `w()`, `wb()` | Существующая legacy-морфология/word bank; не WebBuilder. |
| blank | Копируемая заготовка, которая может требовать ремонта до запуска. |
| dot-project | Проект-пример в каталоге с точкой; читается точечно, не коммитится в WM. |
| `man/wm` | Human-facing документация фреймворка. |
| `aidocs` | Agent-first карта точных контрактов для Codex. |
| `man/sug` | Последовательно нумеруемые предложения, требующие approval. |

Если один термин используется в коде в нескольких ролях (например `site()`),
документация обязана называть конкретный слой и путь реализации.
