<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);

js::req(-1, false, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js');
css::req(-1, false, 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css');
?>
/*
    https://v3.ru.vuejs.org/ru/guide/plugins.html#%D1%81%D0%BE%D0%B7%D0%B4%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8%D0%BD%D0%B0
    js/vue-router/4.0.12/vue-router.global.js:3477
    js/vuex/4.0.2/vuex.global.js:969
*/
var VuePlugin = (function (vue) {
    const _log = Log.for('PLUGIN')

    const plugin = {
        msg: function(html){
            M.toast({ html })
        }
    };

    return {
        install: function(app){
            //const plugin = this;
            app.config.globalProperties.$plugin = plugin;
            _log('install', { 'app.prototype': app.prototype, arguments: arguments })
        }
    }
}(Vue));
