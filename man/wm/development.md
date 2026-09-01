# Разработка в WM

Новый код начинается с current v2 и минимального подтверждённого contract.
Legacy читается точечно, когда требуется сопровождение или миграция.

## Runtime и стиль

- PHP 7.2, `short_open_tag=On`, в framework/project коде короткие теги.
- Vue 3 для новых приложений; Vue 2 только legacy.
- Новые файлы, directories, CSS names и изображения — kebab-case.
- PHP/JavaScript variables — camelCase; крупные сущности могут быть PascalCase.
- Legacy names не переименовываются попутно.
- DRY прагматичный: маленький осознанный повтор лучше преждевременной
  абстракции.

## Цикл изменения

1. Определить owner и реальный entry point.
2. Найти definition, вызовы и consumers.
3. Свериться с current v2 и профильной документацией.
4. Изменить минимально необходимое.
5. Выполнить пропорциональную проверку.
6. Обновить human docs и точную карточку `aidocs`.

## Проверка по типу изменения

| Изменение | Минимум |
|---|---|
| PHP | Lint в PHP 7.2 с short tags и целевой call. |
| Page/router | Direct URL, 404, redirect, query и reload. |
| API | Method, status, validation, auth/ACL и error response. |
| Asset | HTTP status, Content-Type, source order и `qv()`. |
| Vue | Mount, loading/error, back/forward и direct reload. |
| UI | Target viewport и WD reference/live при наличии. |

Тесты по умолчанию находятся в project root `test/`. Component-local test —
исключение, когда внутренний context нельзя воспроизвести иначе.

## Безопасные границы

Не переносите в source или документацию credentials, tokens, settings values,
customer data и большие product/catalog JSON. Debug и `console.log` допустимы,
но не должны раскрывать закрытые значения.
