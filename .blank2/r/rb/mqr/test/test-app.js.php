<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'//,
//'dirUrl'
);
$Self = _rb::self();
$n = $Self::nc();

$mq = gt_on('mq', true);
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra($mq),
	$js['provide/mqr'] = $Self::path('provider/v1/mqr.js.inc'),
	//$js['provide/mqr'] = $Self::path('provider/v2/mqr.js.inc'),
	__FILE__
), SITE_CACHE);

rb('page', 'webkit', 'vue-env-2');
js::wreq('ppath.jq');
rb('vue', 'jsCollectStylesInBody');

?>

<? include $js['provide/mqr']; ?>

var _log = Log.for('MQRDBG');

VueRoot.vue.init({
    mount: 'BODY',


    decl: function(_log){

        return {
            _vue: {
                provide: [
                    //'aaa',
                    //'aaaa',
                    { 'mqr': {
						<? rb('mqr', 'req_css', 'mqr') ?>
					} }
                ],
            },

            data(){
                return {
                    //pageTitle: '…',
                    mqList: [],

                    showTest1: {},
                }
            },

            methods: {


                //@mqr
					//initMQAutoResize
					//MQAutoResize
					//splitValueAndUnit
					//convertStringToTypedValue
					//isNumeric
            },

            computed: {},

            watch: {},

            mounted(){

                var mq = <?=var_export($mq)?>;
                if (mq) this.initMQAutoResize();

            }

        }
    }

});