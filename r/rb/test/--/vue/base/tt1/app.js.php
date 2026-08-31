<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/test/vue/base/tt1/test-vue-base-tt1.class.php';

_needphp('headers');
$Self = _rt::name('test-vue-base-tt1');
$n = $Self::nc();
//dx($n);

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

//$Self::req_vue('titul');
//source::req_name('vuetify');
//js::wreq('wait-list');
?>

var _log = Log.for('<?=$n?>');
const _rr = VueRoot.root;
const _rp = VueRoot.pick;


const Api = WebApi({
    baseUri: '<?=$Self::path('api')?>',
    delay: 380,
    fallback: function(ctx){
        //_r.vue.log('API/fail', ctx);
        console.log('API/fail', ctx);
    },
    onError: function(ctx){
        //_r.vue.log('API/error', ctx);
        console.warn('API/error', ctx);
    },
});


VueRoot.vue.init({
    mount: true,

    use: {
        //'vuetify': Vuetify.createVuetify(),
    },


    decl: function(_log){
        return {
            data(){
                return {
                    headline: 'BASE TT1',
                }
            },
            methods: {},

            mounted(){
                _log('mounted-r', { router: this.router })
            }
        }
    },

});