<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers',
	'dirUrl'
);

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

$dirUri = dirUrl(__FILE__);


#== https://v3.ru.vuejs.org/ru/guide/component-dynamic-async.html#%D0%B4%D0%B8%D0%BD%D0%B0%D0%BC%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B5-%D0%BA%D0%BE%D0%BC%D0%BF%D0%BE%D0%BD%D0%B5%D0%BD%D1%82%D1%8B-%D1%81-keep-alive

?>
const app = Vue.createApp({
    data() {
        return {
            currentTab: 'tab1',
            tabs: ['tab1', 'tab2'],
        }
    },
})

app.mount('#dynamic-component-demo')

