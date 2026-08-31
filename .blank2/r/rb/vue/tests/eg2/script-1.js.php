<?#2.1439
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

?>

const model = {
    data() {
        return {
            counter: 0
        }
    },
    mounted() {
        setInterval(() => {
                this.counter++
        }, 1000)
    }
}

var App = Vue.createApp(model);
//App.mount('#hello-vue');


App.mount('#counter');
