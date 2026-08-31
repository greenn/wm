# Connectors: IQ, library и RM

## Три разных понятия

### IQ connector

Подключает окружение сайта или проекта. Типичные файлы:

```text
site/iq.inc
<project>/iq.inc
```

IQ загружает `web`, регистрирует `iqSite`/`iqPro`, выставляет env, paths, settings/router/pages и выбирает текущий site/project. IQ не является component connector-ом.

### Library connector

Подключает внешнюю или общую библиотеку по соглашению:

```text
web/lib/<name>/<name>.php
```

Вызов:

```php
<? _lib('<name>'); ?>
```

Подробности находятся в `2 lib.md`.

### RM component connector

Делает конкретную директорию компонентом конкретного named RM:

```text
<rm-root>/<component>/<component>.class.inc
```

Минимальная форма на примере проектного RM:

```php
<?
_gss3::reg('card', array(
	'nc' => array(
		'base' => 'Card'
	)
));

class gss3_card extends gss3 {
}
```

Для `rb` используется `_rb::reg(...)` и класс `rb_<component>`, для `lay` — `_lay::reg(...)` и `lay_<component>`. Для другого named RM используются его фактические manager/base class и naming contract.

## Что делает RM connector

`_rw::req(<component>)` строит путь через manager `rDir()` и соглашение `<component>.class.inc`. Connector:

1. регистрирует component config;
2. задаёт `rName`, `rDir`, class name и connector path прямо или через defaults manager-а;
3. объявляет component class;
4. может подключить только необходимые зависимости компонента.

После регистрации manager создаёт/кеширует component instance, а внешние вызовы идут через named helper либо generic resource dispatcher.

## Обязательные проверки

- Имя component в `reg()` совпадает с путём и ожидаемым именем connector-а.
- Объявленный class совпадает с `className()` manager-а либо явно указан в config.
- Connector не маскирует другой component повторной регистрацией без осознанной причины.
- Templates и support-папки без собственного connector-а не попадают в перечень components.
- Отсутствующий connector не трактуется как «ленивый component»: это обычная директория до явного доказательства обратного.

## Запрещённые смешения

- Не называть `iq.inc` connector-ом RM-компонента.
- Не подключать библиотеку через `_needphp()` вместо `_lib()`, если она следует library contract.
- Не считать `<component>.class.inc` bootstrap-ом всего сайта.
- Не придумывать универсальный connector, который автоматически регистрирует все директории.
- Не копировать старую сигнатуру helper-а в v2 без проверки текущего manager-а.
