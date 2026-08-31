<?#5.2.22
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
$jsDir = $Self::relDir('env-js');

$v = 1;
if (gt_on('v3')) $v = 3;


$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra($v),
	$js['utils'] = "$jsDir/utils.js.inc",
	    $js['utils/time'] = "$jsDir/utils/time.js.inc",
	    $js['utils/set'] = "$jsDir/utils/set.js.inc",
	        $js['utils/set1'] = "$jsDir/utils/-set1.js.inc", //007
	        $js['utils/set2'] = "$jsDir/utils/set2.js.inc",
        $js['utils/lodash'] = "$jsDir/utils/lodash.js.inc",
	$js['form'] = "$jsDir/form.js.inc",
	    //$js['form/fieldA']
            $js['form/validator'] = "$jsDir/form/validator.js.inc",
            $js['form/fieldA/align'] = "$jsDir/form/fields-a/alignFieldData.js.inc",
            $js['form/fieldA/item'] = "$jsDir/form/fields-a/makeFieldItem.js.inc",
            $js['form/fieldA/values:'] = "$jsDir/form/fields-a/fieldsValue.js.inc",
	    $js['form/fieldP'] = "$jsDir/form/fields-p.js.inc",
	    $js['form/buttonP'] = "$jsDir/form/button-p.js.inc",
	$js['web'] = "$jsDir/web.js.inc",
	$js['page'] = "$jsDir/page.js.inc",
	$js['api'] = "$jsDir/api.js.inc",
	    $js['api/axios'] = "$jsDir/api/api-axios.js.inc",
	    $js['api/jquery'] = "$jsDir/api/api-jquery.js.inc",
	    $js['api/made'] = "$jsDir/api/api_made.js.inc",
	$js['vuex'] = "$jsDir/vuex.js.inc",
	$js['store'] = "$jsDir/store.js.inc",
	$js['_log'] = "$jsDir/_log.js.inc",
	$js['_app'] = "$jsDir/_app.js.inc",
	$js['_vue'] = "$jsDir/_vue.js.inc",
        $js['decl/cmd'] = "$jsDir/_vue/cmd.js.inc",
        //$js['decl/provide'] = "$jsDir/_vue/provide.b2.js.inc",
	    $js['decl/provide'] = "$jsDir/_vue/provide.js.inc",
            $js['decl/provide/link'] = "$jsDir/_vue/provider/link.js.inc",
            $js['decl/provide/reg'] = "$jsDir/_vue/provider/reg.js.inc",
            $js['decl/provide/parent'] = "$jsDir/_vue/provider/parent.js.inc",
            $js['decl/provide/date'] = "$jsDir/_vue/provider/date.js.inc",
            $js['decl/provide/fq'] = "$jsDir/_vue/provider/fq.js.inc",
            /*$js['decl/provide/crud'] = "$jsDir/_vue/provider/crud.js.inc",
                $js['decl/provide/crud/create'] = "$jsDir/_vue/provider/crud/create.js.inc",
                $js['decl/provide/crud/update'] = "$jsDir/_vue/provider/crud/update.js.inc",
                $js['decl/provide/crud/remove'] = "$jsDir/_vue/provider/crud/remove.js.inc",
                $js['decl/provide/crud/copy'] = "$jsDir/_vue/provider/crud/copy.js.inc",
                $js['decl/provide/crud/aproove'] = "$jsDir/_vue/provider/crud/aproove.js.inc",
                $js['decl/provide/crud/reject'] = "$jsDir/_vue/provider/crud/reject.js.inc",*/
        $js['decl/init'] = "$jsDir/_vue/decl-init.js.inc",
	        $js['decl/data'] = "$jsDir/_vue/decl-data.js.inc",
        $js['decl/router'] = "$jsDir/_vue/decl-routes.js.inc",
        $js['decl/store'] = "$jsDir/_vue/decl-store.js.inc",
        $js['decl/mounted'] = "$jsDir/_vue/decl-mounted.js.inc",
        $js['decl/directives'] = "$jsDir/_vue/decl-directives.js.inc",

	$js['vue-directives'] = "$jsDir/vue-directives.js.inc",
	    $js['vue-directives/visible'] = "$jsDir/vue-directives/visible.js.inc",

	$js['vue_app'] = "$jsDir/vue-app.js.inc",
	/*$js['vue_app_root'] = "$jsDir/vue-app-root.js.inc",
        $js['vue_app_root/decl'] = "$jsDir/vue-app-root/vue-app-root.decl.js.inc",
        $js['vue_app_root/routing'] = "$jsDir/vue-app-root/vue-app-root.routing.js.inc",
	*/
	$js['vue_root'] = "$jsDir/vue-root.js.inc",
        $js['vue_root/decl'] = "$jsDir/vue-root/decl.js.inc",
        $js['vue_root/root-decl'] = "$jsDir/vue-root/root-decl.js.inc",
    	$js['vue_root/vue-decl'] = "$jsDir/vue-root/vue-decl.js.inc",
    	$js['vue_root/api'] = "$jsDir/vue-root/vue-api.js.inc",
    	$js['vue_root/component'] = "$jsDir/vue-root/component.js.inc",
            $js['vue_root/addComponent'] = "$jsDir/vue-root/component/addComponent.js.inc",
            $js['vue_root/loadComponent'] = "$jsDir/vue-root/component/loadComponent.js.inc",
            $js['vue_root/componentCall'] = "$jsDir/vue-root/component/componentCall.js.inc",
	    $js['vue_root/router'] = "$jsDir/vue-root/router.js.inc",
	    $js['vue_root/init'] = "$jsDir/vue-root/init.js.inc",
	    $js['vue_root/dbg'] = "$jsDir/vue-root/dbg.js.inc",



	__FILE__
), SITE_CACHE);
/*foreach ($js as $id => $file) {
	$js[$id] = array(is_file($file), $file);
}
dx($jsDir, $js);*/

$Self::req_css('transitions');

source::req_name(
	'vue',
	'jquery',
	'lodash',
	'pending_fn',
	'w-storage',
    'axios',
    'emittery',
    'vue-router'
    //'vuex',
    //'vue-storage',
    //'vuetify',
);


?>

var _dbg = {
    lastId: 0,
    add(value, name){
        if (typeof name !== 'string' || this.isNumeric(name)) {
            name = this.lastId++
        }
        this[name] = value;
    },
    isNumeric(value) {
        return !isNaN(parseFloat(value)) && isFinite(value);
    }
};


const l = {} //стек опций под _log
l.loading = !1;
l.route = !1;
l.cmpt = !1; //порядок загрузки/добавления компонентов в _App


<? include $js['_log'] ?> //Log
var _Log = Log.for('vue'); //vlog
var dlog = Log.for('DBG');

<? include $js['utils'] ?> //_debounce, _clearObject, _clone, _clearClone, _pickAttrs, _delay, makeSet

<? include $js['web'] ?> //WebHelper

<? include $js['page'] ?> //Page

<? include $js['form'] ?> //Form

<? include $js['store'] ?> //Store

<? include $js['api'] ?> //WebApi

<? include $js['vuex'] ?> //vuexCfg


//I)
<? include $js['_app'] ?> //_app



let _App; //декла приложения |VueApp|App>$App|
    //вообще это - несмонтированный инстанс (экземпляр приложения по декле)
    //декла - объект настроек корневого компонента
/*
    _App = Vue.createApp(decl) /  rb/vue/env-js/_vue-app.js.inc:18
    _App.use(AppRouter);
    _App.component(name, decl)

*/
let App; //смонтированное приложение |App>$App|
let AppRouter; //Vue Router
let AppRoutes = []; //Vue-Router
let AppDirectives = {}; //используемые директивы //0
let _Decl = {}; //деклы компонентов

var Bus = new Emittery(); //event bus
<? include $js['_vue'] ?> //_vue

//I)
<? include $js['vue_app'] ?> // vue_app

//II)
    <?/*
        Root - Wrapper for VueApp
        _Root - декла для рут

    */?>
    //let _root = {}; //экземпляры App
    <? //include $js['vue_app_root'] ?> // vue_app_root(), vue_app_root_init
//const Root = vue_app_root();

//III)
<?/*
    ug
        r/rb/vue/test/app/5/

*/?>

<? if ($v == 3) { ?>

    <? include $js['vue_root'] /*
        VueDecl{},
        VueRoot
            App - Vue-приложение
            $App - смонтированное Vue-приложение
            AppRouter - Vue-роутер

            _root  - self Объекта :: return _root;
            _list - список добавленных компонентов
                    черезщ
                        не все они содержатся внутри App
                доступ через
                Root()
        {
            init - return App;
            mount

            addComponent
            loadComponent

            init_router
            collectRoutes
        }
     */?>

<? } ?>


