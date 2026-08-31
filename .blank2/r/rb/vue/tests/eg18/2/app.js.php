<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'//,
	//'dirUrl'
);

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

//$dirUri = dirUrl(__FILE__);


#== https://v3.ru.vuejs.org/ru/guide/component-custom-events.html#%D0%B8%D1%81%D0%BF%D0%BE%D0%BB%D1%8C%D0%B7%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BD%D0%B5%D1%81%D0%BA%D0%BE%D0%BB%D1%8C%D0%BA%D0%B8%D1%85-v-model

?>

const HelloVueApp = {
    components: {
        UserName,
    },
    data() {
        return {
            firstName: 'John',
            lastName: 'Doe',
        };
    },
};

Vue.createApp(HelloVueApp).mount('#v-model-example')
//app.mount('#editor')