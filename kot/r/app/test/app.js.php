<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers',
	'dirUrl'
);
$Self = _kot::self();
$n = $Self::nc();

$mount = gt('mount');
if ($mount) {
	$mount = urldecode($mount);
} else {
	$mount = true;
}

dx(10);

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	__FILE__
), SITE_CACHE);

//$Self::req_js(1, 'app-env');

?>
_aKot.vue.init({
    mount: <?=var_export($mount, true)?>,

    use: {
        'vuetify': Vuetify.createVuetify(),
        //'vue-material': VueMaterial
    },


    decl: function(_log){
        return {
            props: [
                //'pane'
            ],

            data(){
                return {}
            },
            methods: {},
            computed: {},
            watch: {},
            mounted(){
                _log('mounted');
            }
        }
    },

    /*router: {
        nohashRouter: true,
        //baseUri: '/kot',
    },*/


    afterMount: function($App){}

});