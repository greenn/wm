# Legacy reference map

Legacy используется для восстановления терминов и совместимости, не как шаблон
нового проекта.

| Источник | Что можно извлечь | Ограничение |
|---|---|---|
| Старый `C:\S17\OpenServer\domains\18.web\._\man` | Названия сущностей и исторические пояснения | Сверять с v2; не копировать целиком. |
| `web/php/site/v1` | Старые site/RM/pages helpers | Не переносить в новый v2. |
| Старые `iq/config/pages`, `iq/pages`, routers | Эволюция page fields и routing | Current pages v2 каноничны. |
| `.kp`, `.zo`, `.tosno`, `.kp2` | Примеры admin/project layouts | Только примеры, не default. |
| Старые Vue tests/components | Поведение и идеи UI | Vue 2 не копировать; адаптировать к Vue 3. |
| Первая строка legacy `web.php` | Версия конкретного web snapshot | Не приравнивать к версии WM. |

Любое утверждение из legacy получает статус `legacy` до подтверждения current
кодом или владельцем. Абсолютные пути, settings, credentials и product data не
переносятся.
