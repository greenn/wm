<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rw::name('tool-man');
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra(),
	__FILE__
), SITE_CACHE);
?>

vue_app(function(_log){
    _log.set_({
        //'mounted': 0
    })

    return {
        _vue: {},
        data: function(){ return {} },
        mounted: function() { _log('mounted') }
    }

}, function(){
    App = _App.mount('#man');
})

