# Assets WM

WM не использует обязательный frontend build pipeline. Project-wide assets
живут в `css`, `js`, `fonts`, `i`; component-specific resources — рядом с
owner RM component.

## Source manager

`web/php/site/v2/source.class.php` и `rt` собирают ordered CSS, JS и Vue
sources, дедуплицируют одинаковые requests и применяют `qv()` к URL.

```php
<?
$Self::req_css(-1, 'view');
$Self::req_js('view');
$Self::req_vue('catalog-card');
```

PHP-generated CSS/JS возвращает правильный Content-Type и не выводит warning.

## Shared providers

| Тип | Подтверждённые roots |
|---|---|
| CSS | `animate/411`, `csshake/1.7.0`, `materialize/1.0.0` |
| JS | `jquery/1.12.4`, `lodash/4.17.21` |
| Vue | `vue/3.2.20`, `vue-router/4.0.12`, `vuex/4.0.2`, `vuetify/3.3.14` |

Vue 3 — current. Большие test/research trees содержат Vue 2 и не копируются
в новый код.

## Images и fonts

Project image environment и static `_i::...` — разные APIs. `_i::svg()` читает
raw SVG, поэтому принимает только доверенный file.

NAMU и Suisse entries структурно подтверждены. Formular имеет missing filename,
Urbanist — broken target paths. JACKPORT, Netflix и Suisse требуют проверки
прав распространения.

## UV, WD и MQR

`site/uv/<sid>[<host>].uv` — canonical URL-version database; `qv()`, `qvc()` и
`qve()` добавляют cache-busting query. UV value не является версией WM/web.

WD открывается как `/wd/<preset>` и сравнивает reference/live через overlay,
opacity и outlines. MQR — optional runtime scaler по `[mqr]`, а не CSS media
query.
