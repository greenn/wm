<?
//app обёртка для запуска vue компоненты в wd-пространстве
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	__FILE__
), SITE_CACHE);


source::req_name('vuetify');

?>
VueRoot.vue.init({ //_aWD
    appName: 'WDVue',
    mount: '#wd-vue-3',

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