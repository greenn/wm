<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rw::name('tool-css');
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra(),
	__FILE__
), SITE_CACHE);

//wjs::req('storage');
//site_js::req_name('jquery');
?>

vue_app(function(_log){
    //_log('0', _log.nextIndex(), _log.nextIndex());

    return {
        //beforeCreate: function(){ _log('beforeCreate'); },
        //beforeMount: function(){ _log('beforeMount'); },
        //beforeUpdate: function(){ _log('beforeUpdate'); },
        //created: function(){ _log('created'); },
        //mounted: function() { _log('mounted') },
        data: function(){
            //_log('data');
            return {}
        },
        methods: {},
        watch: {},
        components: {},
    }

}, function(){
    App = _App.mount('#app');
})

