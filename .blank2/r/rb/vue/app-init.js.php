<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

//$Self = _rb::self();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	__FILE__
), SITE_CACHE);
?>


vue_app(function(_log){
    _log('0');
    return {
        data: function(){ return {} },
        methods: {},
        watch: {},
        components: {},
        mounted: function() {
            //_log('mounted', _app('app'))
        }
    }

}, function(){

    App = _App.mount('#app');
})

