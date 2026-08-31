# Images и image environment

В current v2 существуют два разных интерфейса с похожим именем.

## Project image environment

`i(...)` обращается к image environment текущего project. Функция
`_i($proSid, ...$args)` направляет тот же env-вызов в явно указанный project.
Например, gss3 регистрирует собственный handler `i_gss3`.

Точные методы env (`uri`, `path` и другие) проверяются по зарегистрированному
handler конкретного project; нельзя считать их статическим API класса `_i`.

## Static helper

Класс `_i::...` наследует `_img` и по умолчанию работает с каталогом
`<ROOT>/i`. Подтверждённые методы включают `name`, `path`, `has`,
`size`, `uri`, `data`, `img` и `svg`.

Функция `_i(...)` и статический вызов `_i::...` — разные механизмы.

## Правила

- использовать project env для project-specific image roots;
- использовать static helper только когда его `ROOT/i` contract подходит;
- не собирать host/path вручную, если helper учитывает внешний root;
- задавать alt/размеры/lazy loading по смыслу;
- SVG из недоверенного источника не вставлять raw;
- новые имена файлов — kebab-case;
- URL версионировать через текущий source/`qv()` механизм.
