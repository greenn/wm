# Ресурсы WM

Status: current map; отдельные карточки помечают legacy, blank и unresolved.

Эта ветка `aidocs` описывает resource layer и именованные Resource Managers
(RM). Она не заменяет human-документацию и не делает непроверенный каталог
компонентом.

## Маршрут чтения

1. [resource-layer.md](resource-layer.md) — ядро `rw/_rw/rt` и цепочка вызова.
2. [connectors.md](connectors.md) — различие IQ, library и RM connectors.
3. [rb.md](rb.md) — полный список 26 components `r/rb`.
4. [lay.md](lay.md) — полный список 6 components `r/lay`.
5. [site.md](site.md) — IQ-site и незакрытый v2 gap named RM `site`.
6. [admin.md](admin.md) — подтверждённые legacy manager/entry и отсутствующий
   committed root нового admin RM.
7. [gss3.md](gss3.md) — project RM из current-примера `.vmk4/gss3`.
8. [blank-rm.md](blank-rm.md) — минимальный исполняемый named RM и его
   диагностический контракт.
9. [templates.md](templates.md) — template contract и Vue-пары.

## Неподвижные правила

- `r` — resource layer, не единый RM.
- Named RM может храниться в любом месте, которое возвращает его manager
  `rDir()`.
- Component существует только при точном entry
  `<rm-root>/<component>/<component>.class.inc`.
- Каталог шаблонов, data, test или support без такого entry не становится
  component.
- IQ connector, library connector и RM component connector — три разных
  механизма.
- Для нового кода используется v2; legacy не переименовывается и не копируется
  как новый образец.

Status `current` в таблицах означает соответствие текущему v2 loader и
структуре snapshot. Это не утверждение, что каждый component прошёл отдельный
runtime smoke test.
