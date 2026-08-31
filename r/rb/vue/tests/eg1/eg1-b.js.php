<?#1.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

?>

const HelloVueApp = {
    data() {
        return {
            message: 'Hello Vue!!!'
        }
    }
}

Vue.createApp(HelloVueApp).mount('#hello-vue')