# Filesystem, HTTP и rendering

## Filesystem

`_needphp('file')` загружает собственные helpers из `web/php/file/`:

```php
chmodVal($val, $defVal = 0755)
ensureDir($dirPath, $chmod = true)
ensureFileDir($filePath, $chmod = true)
save_file($path = false, $content = '', $chmod_file = false, $chmod_dir = 0777)
create_file($path = false, $chmod_file = false, $chmod_dir = 0777)
file_backup($path, $dirname = true, $suffix_pattern = '[Y.m.d H-i-s.u]')
copy_file($srcPath, $destPath = true, $existSol = COPY_FILE__EXIST_SKIP)
copy_dir($srcPath, $destPath, $depth = 0, $existSol = COPY_DIR__EXIST_SKIP)
move_file($srcPath, $destPath, $existSol = MOVE_FILE__EXIST_SKIP)
move_dir($srcPath, $destPath, $depth = 0, $existSol = MOVE_DIR__EXIST_RENAME)
unlink_dir($dirPath)
unique_path($src, $suffixPattern = '[%s]')
unique_filepath($src, $ext = false, $suffixPattern = '[%s]')
unique_dirpath($src, $suffixPattern = '[%s]')
isSubFolder($subDir, $parentDir)
```

`file.php` загружает `copy_dir` дважды; `include_once` делает это без повторного
execution, но duplicate показывает исторический характер aggregator-а.

Перед любым write/move/delete:

1. разрешить абсолютный target;
2. проверить containment, не использовать неразрешённый glob/env path;
3. определить поведение при существующем destination;
4. сохранить пользовательские файлы и unrelated changes;
5. проверить return/error исходной функции — многие helpers не бросают
   exception.

## Directory/path conversion

```php
dirToArray($pathRequest, $depth = -1, $keepDots = true)
dirFindFirst($value, $type = 'filename', $dir = true, $depth = 0, $set = array())
dirUp($path = true, $times = 1)
dirUrl($path = false, $leadingSlash = true, $trailingSlash = null)
dirVar($path = false)
fileUrl($path = true, $leadingSlash = true, $ROOT = true)
fileVarName($path = false, $trimExtension = true)
rootLess($pathString, $slashAlign = false, $ROOT = true)
hostLess($pathString)
```

`dirToArray.class.php` добавляет filtering/exclusion/listing. Его recursive
output нельзя направлять на закрытые/project data без заданных exclusions.
`dirUrl.php` ссылается на `_needphp('php')`, но physical файл называется
`php-.php`; эту зависимость сначала проверять.

## URL parsing

```php
parseUrl($string, $component = true)
parseTokens($stringUri = '')
parseQuery($stringQuery = '', $responseType = 2)
url_set($url, $prmSet, $prmUnset = array())
urlNames($fullUrl)
urlToken($url = true, $dirRelative = false)
url::q_ar($q/*, more */)
url::q_split($uri)
url::q_ext($str, $q/*, more */)
```

`urlToken()` возвращает parser object `_urlToken`; его `opt*` methods работают
с query options. Эти helpers не заменяют allowlist/validation redirect URL.

## Cache busting `uv`

```php
uv($url, $vType = true)
qv($uri, $qs = false, $vType = false)
qvc($uri, $qs = false)
qve($uri, $qs = false)
```

Call chain:

```text
iqSite::init_uv()
  -> connects project URL-version DB under site/uv
consumer -> qv($uri, ...)
         -> uv($uri, $vType)
         -> urlVersion::match(...)
         -> url::q_ext(..., "qv=<version>")
```

`urlVersion` умеет `db_connect`, `db_fetch`, `match`, `calc`, `save`, `assign`.
`qv()` без подключённой правильной project DB нельзя считать полноценным
cache-busting lifecycle. Canonical data directory проекта — `site/uv`, не
root `uv`.

## Headers, ETag и response body

```php
headers(/* options */)
headers_obj()
headers_assoc()
headersData($type = false)
prevent_headers()
add_etag_ctx($ctx)
clear_sent_headers()

Headers::is304(/* options */)
Headers::cacheRequest($mode = 1, $returnStack = false)
Headers::last($name = false, $otherwise = false)
etag::byCtx($ctx)
etag::basedOnFile($path)
```

`headers()`/class `Headers` могут вызывать `header()`, управлять cache,
Last-Modified/ETag и завершать 304 response в зависимости от options.
Подтверждённые consumers находятся в PHP-generated CSS/JS, например
`fonts/*.raw.css.php`, `js/w/*.js.php`, `kot/.../*.css.php`.

`httpResponse($responseBody)` формирует HTTP response из body; точные headers
и termination нужно проверять в исходнике перед использованием.

## Redirects

```php
redirect($url, $track_info = true)
redirect_with_ref($url)
redirect_info()
doRedirect($url)
getRedirectNextPrm($prmData)
doRedirectNextPrm($prmData)
```

Эти helpers меняют headers и могут сохранять redirect info/session state.
Перед передачей пользовательского URL обязательна проверка допустимого host и
scheme; helper сам по себе не является open-redirect protection.

## Outbound HTTP и mail

```php
htmlByUrl($urlRequest, $options = array(), $extendedResponse = false)
path_get_content($path, $path_get_type = PATH_GET_AS_EXTENSION)
sendMail($mail, $message = array('OK'), $headers = array(), $subject = null, $set = null)
```

`htmlByUrl()` выполняет outbound request и возвращает body либо extended
response. Не отправлять internal URLs/credentials из недоверенного input;
проверять timeout, TLS, status и размер ответа.

`sendMail()` вызывает PHP mail path и ссылается на `_needphp('prop')`, тогда
как physical implementation — `prop.class.php`. До исправления/подтверждённого
bootstrap-а статус dependency unresolved.

## Include/templates

```php
inc($path, $res_type = INC_RES_AS_IS, $_ctx = array())
inc_data($path, $ctx = array(), $res_type = INC_RES_AS_DATA)
qtpl($path, $ctx = array())
_qtpl($relPath, $ctx = array())
qtpl_set($relDir, $relExt = '')
useTemplate(/* $templatePath, $templateCtx, substitutions, regex */)
useTemplate_8($templatePath, $templateCtx = array(),
              $templateSubstitutions = false, $substituteWithRegex = false)
```

`qtpl::apply_path()` исполняет PHP template с context; `qtpl::vue_source()` и
`qtpl::vue_html()` читают Vue/template source. `useTemplate()` выполняет
template и может делать substitutions. Никогда не строить template path из
непроверенного request input.

## Resource helper `r`

```text
_needphp('r')
  -> web/php/r.php
  -> fileUrl, j, rootLess, useTemplate, camelize
  -> web/php/r/{r.class,rc.class,cr}.php
```

`r(...)` создаёт `R` через Reflection. `R` определяет resource paths,
подключает component files/templates/data; `RC` — component-facing helper.
Это PHP resource helper, не правило существования RM component-а: сам
component всё равно требует `<component>.class.inc`.

Не грузить одновременно `r.php` и `r2.php`: оба объявляют `r`, `R`, `RC`.

## Generated JS и CSS

```php
gjs($name)
gjs_($indent, $name)
gjs_replace($tpl, $replacements)
gjs_etag_ctx()

pcss($name/*, args */)
pcss_($conf, $glue = "\r\n")
pcssArg($name, $args = null)
pcss_path($name)
pcss_etag_ctx()
```

`gjs` использует `useTemplate`, indentation и headers; templates находятся в
`web/php/gjs/tpl/*.inc`. `pcss` использует `web/php/pcss/*.css.inc` property
templates. Эти файлы генерируют source/response и не являются frontend build
system.

CSS numeric helpers:

```php
_clamp($value, $minValue = true, $mqMax = true, $mqMin = true, $unit = true)
_clamp2($startValue, $endValue, $mqMax = 1400, $mqMin = 360, $unit = true)
_dec($val, $pct = true, $minCeil = true, $minDec = true, $minVal = true)
_vu($input, $size, $precision = -1)
_vw($input, $size, $precision = -1)
_vh($input, $size, $precision = -1)
```

`css/clamp.php` и `css/clamp1.php` объявляют одинаковые names — выбирать одну
реализацию.

## Images

Entry `web/php/img.php` вызывает `_needphp('img/i_')`. Основные families:

- `img/i_.php`: generated pixels/dashes/data URI (`gi_px`, `gdi_px`,
  `gi_1px`, `gi_dash`, `di_encode`);
- `img/gd.php`: `gdImage` и format helpers;
- `img/pathImage.php`: class `pathImage` (`size`, `gd`, `resize`, `genUid`);
- `img/resize.php`: `i_resize()` и calculation class;
- `img/gd/{p,pt,r,rd}.php`: geometry variants;
- `img/d *`, `img/dd`: old experiments/examples, не default API.

Image operations читают/пишут files, требуют GD и должны валидировать MIME,
размеры, memory limits и destination containment.

Не путать эти helpers с project image environment: в v2 `_i($proSid, ...)`
из `site/v2/iq/iq-pro.php` маршрутизирует вызов к named project, а static `_i`
class в `_img.class.php` — другой API.
