# Assets: CSS и JavaScript

WM допускает статические файлы и PHP-generated CSS/JS без обязательной
frontend-сборки. Источник asset может принадлежать project, site environment,
named RM или component.

Правила:

- component-specific CSS/JS хранить рядом с component;
- project-wide файлы размещать в project `css`/`js`;
- использовать существующие source/env/RM helpers вместо ручной сборки URL;
- URL, требующие cache busting, пропускать через `qv()`;
- PHP-generated CSS/JS выставляет правильный Content-Type, charset и безопасные
  cache headers;
- не включать один asset дважды разными механизмами;
- новый код не требует npm/Vite/Webpack без отдельного решения;
- новые имена — kebab-case, legacy не переименовывается.

При документировании показывать owner, physical path, public URL, loader,
dependencies, порядок подключения, `uv` behavior и consumers. Проверка должна
включать HTTP status, Content-Type, отсутствие PHP warning в output и reload
после изменения версии.
