## GET endpoint

```text
r/<component>/api/list.get.inc
```

## Mutation

```text
r/<component>/api/item.patch.inc
  -> session/auth
  -> action ACL
  -> CSRF
  -> validate payload
  -> atomic update
  -> JSON + status
```

Unknown RM, component и route проверяются отдельно.
