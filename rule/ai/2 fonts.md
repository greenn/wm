# Fonts

Fonts могут храниться в project `fonts`, общей resource-базе или рядом с
компонентом, если шрифт локален для него. CSS-font declaration и сами файлы
документируются как одна зависимость.

Для каждого family фиксировать:

- source/license и допустимые способы распространения;
- реальные `woff2/woff/ttf` файлы и weight/style;
- CSS entry point и public URL;
- fallback stack и `font-display`;
- preload только для действительно критичных вариантов;
- cache busting через текущий asset/`qv()` contract.

Не копировать все fonts из legacy-проекта в новый. Переносить только реально
используемые начертания. Проверять 404, Content-Type/CORS, фактический font face
в браузере и поведение при недоступном файле.
