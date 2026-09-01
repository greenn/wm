# Индекс `web/php/*.php`

## Как читать

Это полный индекс 126 верхнеуровневых PHP-файлов на 2026-08-31. `Entry API`
показывает глобальные функции и классы, которые объявляет сам файл; для
class-heavy модулей перечислены только entry classes, а public methods находятся
в [families.md](families.md). `aggregator` означает, что файл сам почти ничего
не экспортирует, а подключает подпапку.

### Bootstrap, loading и include

| Файл | Entry API / действие | Статус |
|---|---|---|
| `web/php/need.php` | `_needphp(...)`, `_addphp($phpName)`, `_lib($phpName)`, `_needinc($incName)`; подключает class `need` | current |
| `web/php/addphp-.php` | `addphp($phpName)` | legacy |
| `web/php/needphp-.php` | `needphp(...)` | legacy |
| `web/php/php-.php` | `php($phpName, ...)`, `_sphp($callChain, ...)` | legacy |
| `web/php/lib-.php` | `lib($libName)` | legacy |
| `web/php/webinc-.php` | `webinc($incPathName, $set = array(), $reuse = true)` | legacy |
| `web/php/webreq-.php` | `webreq($incPathName)` | legacy |
| `web/php/inc.php` | `inc()`, `inc_data()`, `inc_self()`, `inc_root()` | current/support |
| `web/php/inc.class.php` | class `inc`: `raw()`, `data()` | support |
| `web/php/incRoute.php` | `incRoute($routePath)` | unresolved/legacy |
| `web/php/req-.php` | `req()`, `req_try()`, `req_self()`, `req_root()`, `req_web()`, `req_inc()` | legacy |
| `web/php/needjs.php` | пустой исторический JS-loader sketch | legacy |
| `web/php/site.php` | aggregator с отсутствующим `site/web_r.class.php` | unresolved/legacy |

### Values, state и collections

| Файл | Entry API | Статус |
|---|---|---|
| `web/php/_s.php` | `_s(...)`, `_sp(...)`; session object wrappers | support |
| `web/php/_str.class.php` | class `_str::raw_cut()` | support |
| `web/php/ar.php` | placeholder classes `ar`, `ar_item` | unresolved |
| `web/php/arrayRow.php` | `arrayRow($array, $num/*, $value */)` | support |
| `web/php/cache.php` | `cacheCaller()`, `cached($dataId)`, `cache(...)`, `cacheCountInc()` | legacy/support |
| `web/php/camelize.php` | `camelize($string)`, `mb_camelizeName($string)` | support |
| `web/php/ck.php` | `ck_name()`, `ck(...)`, `ckHas()`, `ckVal()`, `ckDel()` | support |
| `web/php/code.php` | class `code` (`as_string`, `as_array`) | support |
| `web/php/dataPath.class.php` | class `dataPath` | support |
| `web/php/dataPath.php` | `dataPath_error()`, `dataPath()`, `has_dataPath()`, `dataPath2()`, `dataPath1()` | legacy/support |
| `web/php/def.php` | `def($name = null, $value = null)` | support |
| `web/php/dog.php` | `dog()` debug output | legacy |
| `web/php/fq.php` | aggregator quick functions | current/support |
| `web/php/g.php` | `g(...)`, `gHas()`, `gDel()`, `gIncr()`, `gDecr()` | support |
| `web/php/gset.p.php` | `gset(...)`, `_gset(...)` | legacy/support |
| `web/php/gt.php` | GET/ref helpers `gt*`, `gi*`, `grt*`, `gf*` | legacy/support |
| `web/php/incr.php` | `incr($name = false, $withName = false, $nameGlue = '')` | support |
| `web/php/isAssoc.php` | `isAssoc()`, `isOrdinal()`, `isArrayOfArrays()`, `isOrdinalOfArrays()` | support; has bad self-load |
| `web/php/j.php` | `j*` functions; classes `J`, `JC` for JSON-backed data | support |
| `web/php/json.php` | aggregator `json/*` | current/support |
| `web/php/k.php` | `k(...)`; class `K` | legacy/support |
| `web/php/kvs.php` | aggregator class `kvs` | unresolved/support |
| `web/php/ns.class.php` | `nso()`; class `ns` for name/class strings | support |
| `web/php/o.php` | `o(...)`, `o_reg(...)` | legacy |
| `web/php/obj.php` | `obj(...)`; class `obj` | support |
| `web/php/p.php` | empty class `p` | unresolved |
| `web/php/pl.php` | `mapProps`, `valProp`, `pathProp`, `pl`, `ple`; classes `pl`, `ple` | support |
| `web/php/pp.php` | `pp($data, $path, ...)` | support |
| `web/php/prop.class.php` | `_prop()`; classes `_prop`, `props` | support |
| `web/php/s.php` | session helpers `s_*`, `s(...)`, `ss()` | support |
| `web/php/serialization.php` | `try_unserialize($value)` | support |
| `web/php/set.php` | `set(...)`, `is_set()`, `not_set()`, `setArr()`; class `set` | support |
| `web/php/str.php` | aggregator `startsWith`, `endsWith`, `mb_ucfirst` | current/support |
| `web/php/str_indent.php` | `set_indent($string, $indentEach = 1, $opts = true)`, `reduce_min_indent($val, $skipFirstLine = true)` | support/generated source |
| `web/php/strLess.php` | `strLess()`, `pathLess()`, `strTrim()`, `extLess()` | support |
| `web/php/strToByte.php` | `strToByte()`, `mb_strToByte()`, extension/name helpers | legacy/support |
| `web/php/t.php` | `udate()`, `ts_until()`, `tm_ago()` | support |
| `web/php/textTemplate.php` | `textTemplate()`; class `text_pattern` | support |
| `web/php/transliterate.php` | `transliterate($textcyr = null, $textlat = null)` | support |
| `web/php/tx.php` | `tx()`, `tx_ucfirst()`, `ru_month()`, `ru_day()` | support |
| `web/php/u.class.php` | class `_u`: `gen_hash`, `agent_info` | support |
| `web/php/u.php` | `gu()`, `wu()` | legacy/support |
| `web/php/undef.php` | `undef()`, `isUndef()`, `isDef()`; class `undefinedValue` | support |
| `web/php/v.php` | `_v`, `_vv`, `v_`, `v`, `vd`, `vx`, `v_is`, `v_has` | legacy/support |
| `web/php/val.php` | `val(...)`, `val_(...)`, `_val(...)` | legacy/support |
| `web/php/valArray.php` | `valArray()`, `valArrayMap()` | support |
| `web/php/w.php` | `w()`, `wb()`; classes `wordCase`, `word` | legacy morphology; not WebBuilder |
| `web/php/x.php` | `x` store helpers: `x`, `_x`, `xd`, `x_*`, `xc` | support |
| `web/php/x.class.php` | class `x extends xvar` | support |
| `web/php/xvar.class.php` | static class `xvar` | support |

### Paths, filesystem и naming

| Файл | Entry API | Статус |
|---|---|---|
| `web/php/dir_access.php` | `dir_access()`, `path_inside($path, $accessPath = false)` | unresolved/support |
| `web/php/dirFind.php` | `dirFindFirst($value, $type = 'filename', $dir = true, $depth = 0, $set = array())` | support |
| `web/php/dirToArray.class.php` | class `dirToArray` | support |
| `web/php/dirToArray.php` | `dirToArray($pathRequest, $depth = -1, $keepDots = true)` | support |
| `web/php/dirUp.php` | `dirUp($path = true, $times = 1)` | support |
| `web/php/dirUrl.php` | `dirUrl()`, `dirUrl_()` | support; dependency mismatch |
| `web/php/dirVar.php` | `dirVar()`, `dirVar_c()` | support |
| `web/php/file.php` | aggregator `file/*` | current/support |
| `web/php/fileToArray.php` | `fileToArray()`, `arrayToFile()` | support |
| `web/php/fileUrl.php` | `fileUrl($path = true, $leadingSlash = true, $ROOT = true)` | support |
| `web/php/fileVarName.php` | `fileVarName($path = false, $trimExtension = true)` | support |
| `web/php/formatSizeUnits.php` | `formatSizeUnits*`, `filesizeFormat*` | support |
| `web/php/rootLess.php` | `rootLess()`, `hostLess()` | support |
| `web/php/pathValue.php` | `getValueByPath`, `isPathExists`, `setValueByPath`, `pushValueByPath` | support |
| `web/php/path_get_content.php` | `path_get_content($path, $path_get_type = PATH_GET_AS_EXTENSION)` | support |
| `web/php/parseUrl.php` | `parseUrl()`, `parseTokens()`, `parseQuery()` | support |
| `web/php/url.class.php` | class `url` query helpers | support |
| `web/php/url.php` | `url_set($url, $prmSet, $prmUnset = array())` | support |
| `web/php/urlNames.php` | `urlNames($fullUrl)` | support |
| `web/php/urlToken.php` | `urlToken()`; classes `_urlToken`, `opt`, `optUndefined` | support |
| `web/php/getCaller.php` | class/function `getCaller` | support |
| `web/php/formatSec.php` | `formatSec*`, `formatSecHtml`, `formatSecDate` | support |

### HTTP, API, storage и external effects

| Файл | Entry API | Статус |
|---|---|---|
| `web/php/api.php` | `api_default()`, `api()`; includes class `API` | current/support |
| `web/php/crud_json.php` | class `crud_json extends responseData` | support; writes files/session |
| `web/php/csv.class.php` | class `csv` | support |
| `web/php/csv.php` | `read_csv`, `create_csv`, `output_csv_data*` | support |
| `web/php/ft.php` | `getRequestHeaders()` | support |
| `web/php/headers.php` | header helpers; class `Headers` | current/support |
| `web/php/htmlByUrl.php` | `htmlByUrl($urlRequest, $options = array(), $extendedResponse = false)` | support; outbound HTTP |
| `web/php/httpResponse.php` | `httpResponse($responseBody)` | support |
| `web/php/isMobile.php` | `mobileMode($set = null)` | support; `_lib('mobile-detect')` |
| `web/php/microdata.php` | classes `md`, `microdata` | support |
| `web/php/mysql.php` | aggregator mysql classes | unresolved: one missing target |
| `web/php/redirect.php` | `redirect`, `redirect_with_ref`, `redirect_info`; class `redirect_info` | support; headers/session |
| `web/php/redirect2.php` | `doRedirectNextPrm`, `getRedirectNextPrm`, `doRedirect` | support |
| `web/php/response.php` | `response($msgList)`; class `responseData` | support |
| `web/php/scheme.php` | `scheme($schemeData, $opts = false)`; class `scheme` | support |
| `web/php/sd.php` | `_sd($name, $method = false, ...)`; classes in `sd/*` | support/DB |
| `web/php/sendMail.php` | `sendMail(...)` | unresolved dependency; mail side effect |
| `web/php/uv.php` | `uv`, `qv`, `qvc`, `qve`, `uv_gen_page` | current cache busting |

### Rendering, resources и diagnostics

| Файл | Entry API | Статус |
|---|---|---|
| `web/php/_h.class.php` | `_h`, `_hc`, `is_hc`; classes `_h`, `_hc` | support |
| `web/php/dbg.php` | class `dbg` | support/debug |
| `web/php/ghtml.php` | aggregator `ghtml/*` | unresolved target suffix mismatch |
| `web/php/gjs.php` | `gjs*`, `_gjs*`, `gjs_etag_ctx` | support/generated JS |
| `web/php/hex-rgb.php` | `hex2rgb`, `rgb2hex` | support |
| `web/php/html.php` | empty placeholder | unresolved |
| `web/php/htmlAttr.php` | `htmlAttr($content)` | support |
| `web/php/img.php` | aggregator `img/i_` | support |
| `web/php/notch.php` | timing/test helpers `notch*`, `test_*` | support/debug |
| `web/php/page.php` | `buildPage()`; legacy classes `pageComponent*`, `page` | legacy page builder |
| `web/php/pcss-.class.php` | class `pcss::gradientVal()` | legacy |
| `web/php/pcss.php` | `pcss*`, `_pcss*`, `pcss_etag_ctx` | support/generated CSS |
| `web/php/qtpl.class.php` | `qtpl`, `_qtpl`, `qtpl_set`; class `qtpl` | support/template |
| `web/php/r.php` | `r(...)`; current class files `r/*` | current resource path helper |
| `web/php/r2.php` | older standalone `r`, `ry`, classes `R`, `RC` | legacy/conflicts with `r.php` |
| `web/php/rem.php` | `rem*`, `derem`, `dxrem`; class `derem_form` | legacy/debug |
| `web/php/rp.php` | class `rps` | legacy resource/template helper |
| `web/php/rw.php` | aggregator `rw/*` | legacy resource generation |
| `web/php/stacker.php` | classes `stacker`, `new_stacker` | support/source collector |
| `web/php/useTemplate.php` | `useTemplate(...)`, `useTemplate_8(...)` | support/template execution |
| `web/php/wr.php` | class `wr`; `wr_reg`, `wr_get`, `wr_*` | legacy wrapper |

### Other subsystem entries

| Файл | Entry API | Статус |
|---|---|---|
| `web/php/bz.php` | initializes proxy class `bz` with `jbz` | unresolved/support prototype |
| `web/php/log.php` | `slog`, `_log`, `__log`, `_msg`, `_error`, `_dd`; class `log` | support/debug |
| `web/php/o.php` | object registry sugar (also listed under state) | legacy |

## Support-only PHP files без деклараций

Полный coverage включает и файлы, которые выполняют include/output/config, но
не объявляют symbol:

```text
web/php/_s/init.php
web/php/fq/_merge.php
web/php/fq/- d/attr.php
web/php/gt/ref.php
web/php/img/d resize/resize.t5.php
web/php/json/l/js.php
web/php/mysql/mysql_export.class.php
web/php/pro/idb/v1/{app,collapser,db_state,tb_state}.tpl.php
web/php/r/eg/login-page.kotpls.php
web/php/s/{ccc,init,not_init,sss}.php
web/php/site/v1/-css/font_url.dp.php
web/php/site/v1/router/{http-404,mod,plain,redirect,site}.php
web/php/site/v2/iq.php
web/php/site/v2/router/{http-404,mod,plain,redirect,site}.php
web/php/tx/common.dic.php
web/php/uv/uv-page.php
web/php/w/bb/tests.php
```

Верхнеуровневые aggregators без собственных деклараций уже приведены в
таблицах: `bz.php`, `file.php`, `fq.php`, `ghtml.php`, `html.php`, `img.php`,
`json.php`, `kvs.php`, `mysql.php`, `needjs.php`, `rw.php`, `site.php`,
`str.php`.
