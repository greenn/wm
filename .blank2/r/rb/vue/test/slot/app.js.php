<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>
vue_app(function(_log){
    _log('0');
    return {
        data: function(){
            return {
                value: 'App value',
                //items: ['Покормить кота', 'Купить молока']
            }
        },
    }

}, function(){
    App = _App.mount('#app');
})