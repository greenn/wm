# Images

Status: current v2.

## Два разных интерфейса

### Project image environment

`i(...)` вызывает image handler current project. `_i($proSid, ...)` вызывает
handler named project. Реализация dispatch:
`web/php/site/v2/iq/iq-pro.php`.

Пример `gss3`:

    i('uri', 'logo/logo.svg');
    _i('gss3', 'uri', 'logo/logo.svg');

Handler `i_gss3` определён в
`.vmk4/gss3/php/gss3.env.php` и использует directory `gss3/i`.

### Static helper

Class `_i extends _img` находится в `web/php/site/v2/_img.class.php` и
работает с `<ROOT>/i`:

    _i::name($relName, $leadingSlash);
    _i::path($relName);
    _i::has($relName);
    _i::size($relName);
    _i::w($relName);
    _i::h($relName);
    _i::uri($relName);
    _i::data($relName);
    _i::img($relName, $attrs, $style);
    _i::svg($relName);

Функция `_i(...)` и class `_i::...` не взаимозаменяемы.

## Current default tree

Top-level image groups: `i/banner`, `i/icon`, `i/icons`, `i/logo`,
`i/pics`, `i/plans`, `i/posts`, `i/search`, `i/testimonials` и `i/wd`.
Это directories, не RM components.

## Правила

- Project-specific images разрешать через project env.
- Static helper использовать только при верном `ROOT/i` contract.
- `_i::uri()` сам по себе не обещает `qv()`; cache-busting применять через
  текущий source/URL contract у consumer.
- У `img` задавать осмысленный alt, dimensions и loading policy. Встроенный
  `_i::img()` добавляет lazy loading, но не создаёт alt автоматически.
- `_i::svg()` читает raw SVG; не выводить так недоверенный файл.
- Новые filenames — kebab-case; legacy не переименовывать попутно.
