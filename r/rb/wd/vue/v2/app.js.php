<?
//app обёртка для запуска vue компоненты в wd-пространстве
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers',
	'dirUrl'
);

//$apiType = gt('api');
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra($apiType),
	__FILE__
), SITE_CACHE);

?>
_r.vue.init({
    appName: 'WDVue2',
    mount: '#wd-vue-2',

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