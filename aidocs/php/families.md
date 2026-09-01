# Семейства `web/php`

## Область

Здесь перечислены собственные подпапки `web/php`, их entry points и
подтверждённые symbols. Это навигационная карта всех обнаруженных семейств, но
не полный method reference для 2 393 найденных function/method definitions.
Top-level denominator и ограничения описаны в [README.md](README.md), а точные
126 entry-файлов — в [module-index.md](module-index.md).

## Loaders и state wrappers

| Семейство | Файлы и entry API | Статус |
|---|---|---|
| `need/` | `need.class.php`: `need::{php,pro,path,lib,inc,get_info}`; `need_pro.php`: `need_pro(...)`; `need.v2.b.php`: legacy `need(...)` | current + legacy variant |
| `_s/` | `s.class.php`: class `s` (`init`, `data_*`, `prop_*`, `incr`); `sp.class.php`: path-scoped `sp`; `init.php`: bootstrap | support |
| `s/` | `-sInit.php`: `sInit()`; `sv.php`: `sv()` и class `sessionVariable`; `init.php`, `not_init.php`, `ccc.php`, `sss.php`: execution fragments | legacy/support |
| `x.class/` | `_x.php`: local `_x()` factory; основной store — `x.php`, `x.class.php`, `xvar.class.php` | support; не путать с отсутствующим `x/x_.php` |

## API, validation и persistence

| Семейство | Файлы и entry API | Статус |
|---|---|---|
| `api/` | `api.class.php`: class `API`; public entry methods `setOpt`, `setOpts`, `setCtx`, `getRequest`, `error`, `responseData`, `reply*`, `get/post/put/patch/delete`, `run`, `data*`; static `methodData`, `makeMultiData` | support/current consumers |
| `scheme/` | `scheme_api.php`: class `scheme_api` (`decrypt`, dynamic assertion calls); основной validator — top-level `scheme.php` | support |
| `sd/` | `_sd.class.php`: schema/table bootstrap; `sd.class.php`: CRUD-like `add`, `remove`, `set_where`, `update`, `all`, `get*`, `has` | support; DB side effects |
| `mysql/` | `_mysql.class.php`, `mysql.class.php`, `mc.class.php`, `mysql_db.class.php`, `mysql_table.class.php`, `mysql_item.class.php`; `-b/mysql_{conf,create_db,error,has_db,i,verify}.php` | support/legacy mix; aggregator has missing target |
| `bz/` | `i_bz.interface.php`; proxy `bz.class.php`; implementations `jbz`, `fbz`, `mbz` with `init/create/save/set/remove/update` | prototype/unresolved |
| `kvs/` | `_kvs.class.php`, `kvs.class.php` | unresolved: classes are skeletal |
| `pro/` | `pro.class.php`, `pro.fn.php`; `idb.class.php` plus `idb/v1/*.tpl.php` | legacy project/database subsystem |

Главная API-цепочка:

```text
_needphp('api')
  -> web/php/api.php
  -> include web/php/api/api.class.php
  -> api_default(...) creates/caches API
  -> api(...) -> API::run(...) -> API::responseData()
```

`crud_json.php` строится поверх `responseData`, `API`, `scheme`, filesystem и
image helpers; подробности — в [data-and-state.md](data-and-state.md).

## Collections и quick functions

`web/php/fq.php` — aggregator. Он подключает `_is`, `_export`, `_args`, `_arr`,
`_merge`, `utf_str`, `_props`, `_verify`, `assignValue`, `_select`, `_oe`.
Другие helpers семейства существуют отдельно и требуют явной загрузки.

| Файл | Глобальные entry functions / classes |
|---|---|
| `fq/_args.php` | `args_arr()`, `argsArr()`, `argsArrArg()` |
| `fq/_arr.php` | `array_pick()`, `array_ensure()`, `_array_ensure()`, `array_push_key()` |
| `fq/_array.php` | `_array(...)` |
| `fq/_bool.php` | `boolConvert()`, `provideBool()` |
| `fq/_export.php` | `valToStr()`, `val_print()`, `valToJson()`, `val_export()` |
| `fq/_is.php` | `is_digit`, `is_valuable`, `is_mixed`, `is_stringable`, `is_stringed`, `is_true`, `is_false`, `is_number`, `is_true_or_numeric`, `is_true_or_stringable`, `is_array_or_stringable`, `is_null_or_false`, `is_bool_or_null`, `is_propData`, `isnot` |
| `fq/_math.php` | `floor_round()`, `expect_pct_col_sizes()` |
| `fq/_merge.D.php` | `merge()`, `rmerge()`, `extend()`; diagnostic/alternate implementation |
| `fq/_merge.php` | aggregator fragment без declaration |
| `fq/_oe.php` | classes `oe`, `oee`, `ohe` |
| `fq/_prop-chain.php` | `propChain()`, `propChainArg()`, `_propChain()`, `set_propChain()` |
| `fq/_props.php` | `has_items`, `has_prop`, `has_prop_hit`, `prop`, `prop_hit`, `prop_hit_value`, `prop_first`, `prop_filter`, `is_prop` |
| `fq/_select.php` | `sArr()`, `csArg()`, `sArg()` |
| `fq/_str.php` | `str_attr()`, `str_ns()` |
| `fq/_verify.php` | `not_empty()`, `hit_()`, `_hit()`, `hit()` |
| `fq/-transit.php` | `transit()`, `transit_()`, `_transit()`, `data_ctx_transit()` |
| `fq/assignValue.php` | `assignValue($data, $rules, $exist = true)` |
| `fq/attr.class.php` | class `attr` (`value`, `klass`, `css`, `out`, `parse`) |
| `fq/hash.php` | `qhash($data)` |
| `fq/inPropList.php` | `inPropList()`, `_addPropList()` |
| `fq/parseUnitValue.php` | `parseUnitValue`, `parsePctValue`, `parseUnitValue1`, `parsePctValue1`, `parseValueAndUnit` |
| `fq/pickProps.php` | `pickProps()` |
| `fq/prop_ext.php` | `prop_ext()` |
| `fq/rand_val.php` | `rand_val()` |
| `fq/sameUri.php` | `sameUri()` |
| `fq/tag_wrap.php` | `tag_wrap()`, `join_tag_wrap()` |
| `fq/undefined.php` | class/factory `undefined`, `is_undefined`, `not_undefined`, `array_unset_undefined` |
| `fq/utf_str.php` | `utf_str()` |
| `fq/arr/array_update.php` | `array_update()`, `_array_update()` |
| `fq/arr/defaultsDeep.php` | `defaultsDeep()`, `defaultsDeep_v1()`, `defaultsDeepForCtxProp()` |
| `fq/arr/isLast.php` | `isLastOf`, `getLastKey`, `isLastKey`, `arrayKeyLast` |
| `fq/arr/make_arr.php` | `make_arr`, `nArr`, `make_obj`, `nObj` |
| `fq/is/is_includable.php` | `is_includable()` |
| `fq/merge/*.php` | `a_join`, `am`, `bm`, `join_values`, `merge_keys_values`, `merge_keys_value`, `push_value`, `push_uvalue` |
| `fq/str/*.php` | `mb_basename`, `str_css`, `str2val`, `str2valDeep`, `truerawurlencode`, `val2str` |
| `fq/- d/*.php` | alternate/debug `attr_val`, `str_val`, `attr_str`, `n_str`; не грузить вместе с current definition |

## Filesystem и directory families

| Семейство | Файлы и globals | Статус |
|---|---|---|
| `file/` | `chmodVal`; `copy_dir`; `copy_file`; `create_file`; `ensureDir`, `ensureFileDir`; `file_backup`; `isSubFolder`; `move_dir`; `move_file`, `move_file_v1`; `save_file`; `unique_path`, `unique_filepath`, `unique_dirpath`; `unlink_dir` | support, mutating |
| `dirToArray/` | `_dirToArray()`, `dirToArray_set()`; основной class в `dirToArray.class.php` | support |
| `pp/` | class `propPath::{get,has,set,unset}`; top-level `pp()` является facade | support |
| `str/` | `startsWith`, `mb_startsWith`; `endsWith`, `mb_endsWith`, `mb_endsWithAny`; `mb_ucfirst`; `l/urlFilename` | support |
| `serialization/` | `isSerialized`, `is_serial`, `is_serialized`; top-level default загружает только `try_unserialize` | support |

## Output, assets и HTTP

| Семейство | Файлы и entry API | Статус |
|---|---|---|
| `headers/` | `etag.php`: class `etag` (`value`, `verifyRequestHeaders`, `basedOnFile`, `byCtx`, `file`, `lookForCtx`) | support/current asset consumers |
| `ghtml/` | `gh.class.php`: class `gh`, globals `_gh`, `gh`, `gh_opt`; `gs.class.php`: class `gs` snippet generator | unresolved aggregator naming |
| `html/` | `html.class.php`: class `r_html` | support; top-level `html.php` empty |
| `css/` | `cbn`; clamp families; `dec`, `dec_css`; `image1px`; viewport `_vu/_vw/_vh/_vp/_pct` | support with duplicate clamp generation |
| `img/` | `i_.php` generated image/data URI helpers; `gd.php` GD classes; `gd/{p,pt,r,rd}.php`; `pathImage.php`; `resize.php`; `sizeName.php`; `fn.php`; `l/di.php`; `d *`/`dd` are experiments/legacy variants | support + legacy experiments |
| `json/` | `jsonEncode`, `jsonPrettyEncode`, `jsonFile_*`, `jsonLastErrorMsg`, `jsonErrorMsg`, `jsonString`, `jsonTryDecode`, `json_readable_encode`, `outputASJson` | support |
| `needjs/` | `wjs.php`: class `wjs` source builder/exporter | legacy/support; top-level loader empty |
| `uv/` | `urlVersion.php`: class `urlVersion`; `uv-page.php`: output fragment; `conf/*.vq.inc`: config fragments | current cache busting |

## Resources, templates и source collectors

| Семейство | Файлы и entry API | Статус |
|---|---|---|
| `r/` | `r.class.php`: class `R`; `rc.class.php`: class `RC`; `cr.php`: factories `ar()`, `wr()`; `eg/*` examples | current resource helper, не RM connector |
| `rw/` | `rw.class.php`, `_rw.class.php`, `_r.php`; split support classes in `rw/-/*.class.php` for CSS/data/file/JS/log/PDI/template/response | current resource core with legacy/support internals |
| `rp/` | `rp_handler`, `rp_shandler`, `rp_shandler_L`; template/data/path facade | legacy/support |
| `stacker/` | `stacker_calls.class.php`; top-level `stacker.php` stores and exports ordered source requests | support/source collector |
| `gjs/tpl/` | `.inc` JS/templates (`env`, `rc`, `arg_obj`, `app-ol`); no PHP API declaration | support templates |
| `pcss/` | 75-style `.css.inc` property/prefix templates consumed by `pcss()` | support data/templates, not individual modules |

## Site generations

`site/v1` and `site/v2` expose many same global/class names and must not be
loaded together blindly.

| Generation | Files / entry API | Статус |
|---|---|---|
| `site/v2/iq/` | `_iq`, `iqCore`, `iqSite`, `iqPro`; globals `site/_site`, `pro/_pro`, `cur`, `data`, `data_opt`, `cur_opt/site_opt/pro_opt`, `cur_set`, page helpers | current IQ |
| `site/v2/` pages | `_pages`, `_page`, `site_page`, `page_uri`, `site_router`, `page_propPik` | current server pages/router |
| `site/v2/r/` | `rt`, `rb`, `lay` shims/facades | current compatibility layer around resource modules |
| `site/v2/` assets | `_css`, `_cssVars`, `_img`, `source/js/css/vue`, `vue_tpl` | current/support |
| `site/v2/router/` | executable handlers `site`, `plain`, `mod`, `redirect`, `http-404` | current support, no declarations |
| `site/v1/` | `_page`, `_pid`, `_router`, `page`, `pid`, language/CSS/image/source classes, older router handlers | legacy |
| `site/v1/r/` | facades for `acc`, `app`, `cms`, `draft`, `lay`, `rb`, `ripr`, `rt`, `site` | legacy/project-specific |

Каноническое IQ не следует подключать через top-level `web/php/site.php`:
этот файл относится к старой конструкции и содержит отсутствующий target.

## Parsers, logging и morphology

| Семейство | Файлы | Статус |
|---|---|---|
| `parser/` | `strDataParser`; current `strListParser`; `strTabMenuParser`; исторические `strTabMenuParser.v1`, `.v1-5` с тем же class name | support + conflicting legacy variants |
| `log/` | class `log` (`init`, `rec`, `save`, filters, HTML rendering) | support/debug; filesystem write |
| `w/` | Russian word-bank helpers under `bb/rudic`; `w/bb/tests.php`; `w/js/_w.js.php` | legacy morphology, не WebBuilder |
| `url/` | archived `- b/url.1d-17.php` | legacy variant |
| `tx/` | `common.dic.php` dictionary fragment | support data, no declarations |
