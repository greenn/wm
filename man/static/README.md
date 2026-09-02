# WM Documentation — static

Эта папка — готовая к публикации версия документации WM для GitHub Pages.

`index.html` и `assets/` работают без PHP и build pipeline. Интерфейс загружает
`../manifest.json` и Markdown-файлы из `../wm`, `../site`, `../reference` и
других разделов `man`, поэтому `man` остаётся единственным источником текстов.

Для GitHub Pages выберите публикацию из ветки `main`, каталог `/man/static`.
Файл `.nojekyll` нужен, чтобы GitHub Pages не менял обработку статических
файлов. Локально сайт можно открыть через любой HTTP static server из каталога
`man/static`; через `file://` браузер заблокирует `fetch` Markdown-файлов.
