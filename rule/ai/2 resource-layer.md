# Resource layer `r`

## Терминология

`r` — это ресурсный слой WM. Он предоставляет общую механику регистрации, поиска, загрузки, вызова и шаблонизации ресурсов. `r` не является именованным RM.

Именованные Resource Managers: `rb`, `lay`, `site`, `admin`, проектный `gss3` и другие. Каждый из них имеет собственные manager/class/helper-ы и собственный корень ресурсов.

Физические примеры текущего дерева:

```text
<ROOT>/r/rb/          # named RM rb
<ROOT>/r/lay/         # named RM lay
<ROOT>/gss3/r/        # project RM gss3
```

Это примеры, а не обязательная общая вложенность. Named RM может находиться в другом месте, если его manager возвращает этот путь из `rDir()`.

## Ядро слоя

Текущая цепочка реализации:

- `web/php/rw/rw.class.php` — поведение одного зарегистрированного ресурса: config, path/uri, template context, `tpl()`, `call()`;
- `web/php/rw/_rw.class.php` — manager: вычисляет путь connector-а, регистрирует, загружает и кеширует компоненты;
- `web/php/rw/_r.php` — общие dispatch/helper-функции;
- `web/php/site/v2/r/rt.class.php` — v2 resource type с подключением CSS/JS/Vue/API;
- `web/php/site/v2/r/rb.class.php` и `lay.class.php` — конкретные named RM.

Разрешение вызова выглядит так:

```text
named helper / generic dispatcher
  -> manager named RM
  -> manager::req(<component>)
  -> <rm-root>/<component>/<component>.class.inc
  -> manager::reg(<component>, config)
  -> component class
  -> method/template/call/resource
```

## Как определяется компонент

Для компонента `card` обязателен файл:

```text
<rm-root>/card/card.class.inc
```

Внутри connector регистрирует `card` в конкретном manager и объявляет класс компонента. Если точного connector-а нет, директория не является компонентом RM. Она может быть:

- подпапкой шаблонов;
- data/source-каталогом;
- support-кодом;
- заготовкой;
- legacy;
- тестовым или техническим деревом.

Нельзя автоматически создавать connector для каждой найденной директории.

## Контекст и шаблоны

`rw::tpl()` вычисляет путь относительно `rDir` компонента, кладёт переданный context во временный stack, подключает template через output buffering и возвращает строку. Template получает context через `tempCtx()` и задаёт значения по умолчанию локально.

`rw::call()` аналогично вызывает `.inc`-ресурс с context. Прямое `include` из внешнего кода допустимо только там, где существующая архитектура именно этого требует; обычный component/template вызывается через RM.

## Правила изменения

- Новый named RM сначала получает явный manager, component base class и короткие helpers в окружении проекта.
- Новый component получает обязательный `<component>.class.inc`.
- Связанные templates, CSS, JS, Vue и локальные data-файлы держатся рядом с компонентом.
- Общие зависимости выносятся в `rb`, `lay`, `web/php` или `web/lib` только при реальном повторном использовании.
- Не переносить named RM только ради единой красивой структуры: manager уже изолирует физический путь.
- Новые имена директорий и файлов — kebab-case, если существующий локальный стиль не требует иного. Legacy не переименовывать.

## Что документировать для каждого RM

1. Имя RM и назначение.
2. Физический root и код, который определяет `rDir()`.
3. Manager class, base component class и public helpers.
4. Полный список подтверждённых components только по connector-файлам.
5. Для каждого component: connector, class, public methods, templates, calls, CSS/JS/Vue, API/data и consumers.
6. Зависимости от других RM.
7. Отдельный список support/legacy-каталогов без connector-а.
