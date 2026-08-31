<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

?>
var app_id = '#hello-vue';
var model = {
    data: function() {
        var ctx = {
            message: 'Hello Vue!!'
        }
        return ctx;
    }
}

var App = Vue.createApp(model);
App.mount(app_id);
