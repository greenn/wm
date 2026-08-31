<?
//app обёртка для запуска vue компоненты в wd-пространстве
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers',
	'dirUrl'
);

//$Self = _rb::self();

$apiInsert = '';

$apiType = gt('api');
if ($apiType) {
	$apiInsert = "/$apiType";
}

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra($apiType),
	__FILE__
), SITE_CACHE);


source::req_name('vuetify'); //для tooltip

?>
var _log = Log.for('WD-DBG');

const _r = VueRoot;
const _rr = _r.root;
const _rp = _r.pick;


const Api = WebApi({
    baseUri: '<?=hostUrl?>/api<?=$apiInsert?>',
    baseEmuUri: '<?=hostUrl?>/api<?=$apiInsert?>/%method',
    delay: 380,
    fallback: function(ctx){
        _r.vue.log('API/fail', ctx);
    },
    onError: function(ctx){
        _r.vue.log('API/error', ctx);
    },
});

const Web = WebHelper({
    'page-title': {
        'suffix': 'WD Vue',
        'glue': ' | ',
    }
});

_r.vue.init({
    appName: 'WDVue',
    mount: '#wd-vue',

    use: {
        'vuetify': Vuetify.createVuetify(),
    },

    decl: function(_log){
        return {
            data(){
                return {}
            },
            methods: {},
            mounted(){
                _log('mounted');
            }
        }
    },

	//afterMount: function($App){}

});