# Current, legacy и unresolved

Статус — часть contract. Он показывает, можно ли использовать механизм в новом
коде, а не просто существует ли файл.

| Статус | Как работать |
|---|---|
| `current` | Рекомендуемый v2 путь; всё равно проверить consumer и runtime. |
| `legacy` | Только сопровождение или контролируемая миграция. |
| `blank` | Заготовка, требующая технической проверки. |
| `unresolved` | Есть доказанный разрыв; сначала исправить или обойти осознанно. |

## Главные границы

- Pages/IQ v2 и Vue 3 — current для нового кода.
- `site/v1`, старый `_router`, `rb/router` и Vue 2 — legacy.
- Top-level `web/php/site.php` не является current v2 IQ entry.
- `web/php/r.php` и `r2.php` объявляют одинаковые symbols и не грузятся вместе.
- Dash/v1/prototype PHP variants могут конфликтовать с current definitions.
- `w()` и `wb()` относятся к morphology/word bank, а не к будущему
  WebBuilder.

## Не учить по сломанному примеру

`.vmk4`, `.blank` и `.blank2` полезны для понимания структуры, но содержат
известные bootstrap, router и path gaps. Human docs показывают intended current
contract и рядом называют расхождение; они не объявляют snapshot рабочим.

> [!WARNING]
> Нельзя подключать «всё найденное» или создавать alias-файл только ради
> совпадения имени loader. Это может вызвать duplicate declarations и скрыть
> настоящий contract.
