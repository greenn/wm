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

var model = {
    data: function() {
        return {
            message: 'Hello Vue!',
            counter: 0
        }
    },

    mounted: function() {
        var self = this;

        setInterval(function(){
            self.counter++
        }, 1000)
    }
}

var App = Vue.createApp(model);
//App.mount('#hello-vue');


App.mount('#counter');
