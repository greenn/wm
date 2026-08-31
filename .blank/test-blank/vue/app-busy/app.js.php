<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	__FILE__
), SITE_CACHE);
?>

var _log = Log.for('APP-BUSY');
const _rc = VueRoot.ccall;
VueRoot.vue.init({
    mount: 'BODY',
    use: {
        //'vuetify': Vuetify.createVuetify(),
    },
    decl: function(_log){

        return {
            _vue: {},
            data(){
                return {
                    headline: 'App busy'
                }
            },
            mounted(){
                this.clog('App mounted');
            }
        }
    },

});