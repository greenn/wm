# UV — URL versioning

Status: current; canonical databases находятся только в `site/uv`.

## Flow

`iqSite::init_uv()` в `web/php/site/v2/iq/iq-site.class.php` подключает:

    <site-selfDir>/uv/<site-sid>[<hostName>].uv

через `urlVersion::db_connect()`.

`web/php/uv.php` предоставляет:

    qv($uri, $qs = false, $vType = false);
    qvc($uri, $qs = false);   // content version
    qve($uri, $qs = false);   // ETag version

`qv()` добавляет `qv=<version>` и сохраняет переданный query; `$qs === true`
подключает current `pageQuery`.

## Snapshot databases

Canonical files сейчас включают:

    site/uv/gss[spbgss.granitplace.ru].uv
    site/uv/gss[spbgss.ru].uv
    site/uv/gss[vmk4.loc].uv
    site/uv/gss3[].uv
    site/uv/gss3[spbgss.ru].uv
    site/uv/gss3[vmk3.loc].uv
    site/uv/gss3[vmk4.loc].uv

`site/uv/gss[vmk4.loc].uv.tmp` — temporary file, не official database.
Корневой `uv/` — старое noncanonical location.

## Правила

- Не добавлять timestamp на каждый request.
- Не смешивать DB разных site/project/host.
- URL, участвующий в asset stack, версионировать один раз.
- После изменения проверить новый query и actual browser fetch.
- Не массово переписывать database без причины.
- UV value не является версией WM или `web`.
