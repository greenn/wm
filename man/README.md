# WM Developer Documentation Site

Автономный PHP/Markdown сайт. Он не загружает IQ, RM или project runtime и не
требует Node/build pipeline.

## Entry points

- `index.php` — HTML shell и security headers;
- `content.php?action=manifest` — публичная карта без filesystem paths;
- `content.php?doc=<id>` — один whitelisted Markdown document;
- `manifest.json` — navigation, metadata, files и связи;
- `assets/app.css`, `assets/app.js` — local UI и Markdown renderer.

Apache открывает каталог через `DirectoryIndex index.php`. `.htaccess`
запрещает directory listing и прямую выдачу manifest/Markdown; другой web
server должен повторить эти ограничения своей конфигурацией.

## Добавление документа

1. Создать Markdown в тематической папке `wm`, `site`, `admin`, `rm`,
   `reference`, `sug` или `log`.
2. Добавить exact ID и file в `manifest.json`.
3. Добавить ID в нужный navigation section.
4. При необходимости создать отдельный `aside` Markdown для правой колонки.
5. Проверить internal `doc:` links, loading/error state и mobile navigation.

Endpoint принимает только GET, разрешает document ID из manifest и повторно
проверяет `realpath`, containment, extension и размер файла. Markdown renderer
экранирует raw HTML и принимает только `doc:`, fragment, HTTPS и mailto links.
