# Первый работающий ресурсный модуль

Откройте `/blank/rm/index.php` на PHP-сервере с корнем WM. Страница показывает,
как IQ подключает named RM, loader находит connector, а компонент отдаёт
template и свои CSS/JS. Успешный результат — шесть `PASS` и строка
«PASS · сервер, шаблон, CSS и JavaScript».

## Минимальный контракт

```text
blank/rm/iq.inc                 IQ connector проекта
blank/rm/blank-rm.env.inc       named RM blankRm / _blankRm
blank/rm/r/demo/demo.class.inc  connector компонента demo
blank/rm/r/demo/card.tpl.php    HTML template
blank/rm/r/demo/demo.css        CSS компонента
blank/rm/r/demo/demo.js         клиентская проверка
```

Ресурсный модуль не обязан находиться в `r/rb`. Здесь его расположение задаёт
`_blankRm::rDir()`. Каталог становится компонентом только после появления
точного `<component>.class.inc`.

Страница вызывает шаблон через существующий API:

```php
<?
$cardHtml = blankRmTpl('demo', 'card', array(
    'title' => 'Компонент найден. Шаблон работает.',
));
```

RM разрешает путь и передаёт context. Template читает `static::tempCtx()` и
экранирует title. CSS/JS регистрируются через `req_css/req_js`, а ссылки выводит
`_source::html_export()`. Никакого build pipeline не требуется.

## Что означает диагностика

| Сигнал | Подтверждение |
|---|---|
| bootstrap | Подключены shared web и IQ окружение. |
| iq-pro | Текущий проект использует `rMain = blankRm`. |
| connector | Загружен и создан компонент `blankRm_demo`. |
| sources | Файлы существуют, source manager экспортировал их URL. |
| missing-resource | Несуществующий connector возвращает `false`. |
| template | RM API вернул настоящий HTML-фрагмент. |

Отсутствующий `missing-resource` — специально проверяемый отказ. Если любой
контракт не выполнен, сервер отвечает HTTP 500. Безопасный код отображается на
странице, детали exception записываются в PHP error log. Серверные этапы видны
в `console.log`, даже если внешний JavaScript не загрузился.

Итоговый browser PASS дополнительно требует выполнения JS и применения CSS
к template. Кнопка «Проверить ещё раз» повторяет клиентскую проверку.

## Как повторить запуск

Из корня WM:

```powershell
php -n -d short_open_tag=1 -S 127.0.0.1:18724 -t .
```

Откройте `http://127.0.0.1:18724/blank/rm/`. Это локальный диагностический сервер.
На Apache используйте приложенный `.htaccess`: он закрывает внутренние `.inc`
и `.tpl.php`. Встроенный PHP server правила Apache не применяет.

## Проверенный вид и результат

Проверка 08.09.2026, PHP 7.2.34, WM 20.0.5: шесть серверных PASS, HTTP 200
страницы и обоих assets, browser PASS и работающая повторная кнопка.
При временном отсутствии connector, template, CSS или JS получен HTTP 500;
после восстановления файлов — HTTP 200. Title с HTML экранируется.

На desktop — светлая страница, сетка 3×2 и тёмно-зелёная карточка реального
template. При ширине 390 px сетка становится 2×3, карточка одноколоночной;
горизонтального переполнения нет. Скриншоты сохранены рядом с этим документом:
`man/wm/blank-rm/desktop.png` и `man/wm/blank-rm/mobile.png`.

Пример проверяет один RM. Полный site/router/API и UV/qv относятся к следующему
проектному этапу; здесь `qv` явно отключён для двух static assets.
Apache access rules пока не запускались.

Дальше: [ресурсные модули](doc:rm/index),
[полная smoke matrix](doc:reference/testing).
