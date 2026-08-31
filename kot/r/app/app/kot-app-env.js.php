<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers'
);
$Self = _kot::self();
//$n = $Self::nc();

//$baseUri = gt('base', '/');

headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra($baseUri),
	__FILE__
), SITE_CACHE);

$Self::req_js(2, 'kot-app.vue-ext');

source::req_name('vuetify');
//source::req_name('vue-material');
?>
var _log = Log.for('DBG');

const _aKot = VueRoot;
const _arKot = _aKot.root;
const _apKot = _aKot.pick;
_aKot.nm = 'kot';
_aKot.routerDelay = 100;
_aKot.apiDelay = 200;
_aKot.msgTimeout = 2500;

const BusKot = new Emittery(); //event bus

const ApiKot = WebApi({
    baseUri: '<?=hostUrl?>/api/kot',
    baseEmuUri: '<?=hostUrl?>/api/%method/kot',
    delay: _aKot.apiDelay,
    responseAsData: true, //есть successHandler который возвращает сразу response.data
    successHandler: function(cb, response, data, method, url){ //data|sendData|requestData|postData
        if (cb) {
            var responseData = response.data;
            //_log('successHandler', { responseData, method, url, response });
            cb(responseData, data, response)
        }
    },
    fallback: function(ctx){
        _aKot.vue.log('API/fail', ctx);
        _aKot('sys-msg', 'showError', ctx.title, ctx.msg)
    },
    onError: function(ctx){
        _aKot.vue.log('API/error', ctx);
        _aKot('sys-msg', 'showError', ctx.title, ctx.msg)
    },
});

const ApiKMod = WebApi({
    baseUri: '<?=hostUrl?>/api/kmod',
    baseEmuUri: '<?=hostUrl?>/api/%method/kmod',
    delay: _aKot.apiDelay,
    successHandler: function(cb, response, data, method, uri){ //data|sendData|requestData|postData
        if (cb) {
            var responseData = response.data;
            //_log('successHandler', { responseData, method, uri, response });
            if (responseData && responseData['status']) {
                _aKot('msg-pane', 'showStatus', responseData['status'], `${method}: ${uri}`);
            }
            cb(responseData, data, response)
        }
    },
    fallback: function(ctx){
        _aKot.vue.log('ApiKMod/fail', ctx);
        //_aKot('sys-msg', 'showError', ctx.title, ctx.msg)
    },
    onError: function(ctx){
        _aKot.vue.log('ApiKMod/error', ctx);
        //_aKot('sys-msg', 'showError', ctx.title, ctx.msg)
    },
});

const WebKot = WebHelper({
    'page-title': {
        'suffix': '<?=_pro('page-title-suffix')?>',
        'glue': '<?=_pro('page-title-glue')?>',
    }
});