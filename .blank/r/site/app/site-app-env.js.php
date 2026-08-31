<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
//$Self = _acc::self();

rb('page', 'webkit', 'vue-env-2');

headers('js', 'utf8', 'nosniff', etag::ctx(
	__FILE__
), SITE_CACHE);

//$Self::req_js(2, 'app.vue-ext'); //для crud
source::req_name('vuetify'); //для tooltip
///source::req_name('vue-material'); //01

?>
var _log = Log.for('DBG');
const _r = VueRoot;
const _rr = _r.root;
const _rp = _r.pick;
_r.routerDelay = 100;
_r.apiDelay = 200;
_r.msgTimeout = 2500;


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

const SiteApi = WebApi({
    baseUri: '<?=hostUrl?>/api/site',
    baseEmuUri: '<?=hostUrl?>/api/%method/site',
    delay: _r.apiDelay,
    fallback: function(ctx){
        _r.vue.log('API/fail', ctx);
        //_r('sys-msg', 'showError', ctx.title, ctx.msg)
    },
    onError: function(ctx){
        _r.vue.log('API/error', ctx);
        //_r('sys-msg', 'showError', ctx.title, ctx.msg)
    },
});


const SiteWeb = WebHelper({
    'page-title': {
        'suffix': '<?=_pro('page-title-suffix')?>',
        'glue': '<?=_pro('page-title-glue')?>',
    }
});