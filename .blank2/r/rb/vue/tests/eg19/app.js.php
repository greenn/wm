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


#== https://v3.ru.vuejs.org/ru/guide/component-props.html#%D0%B2%D0%B0%D0%BB%D0%B8%D0%B4%D0%B0%D1%86%D0%B8%D1%8F-%D0%B2%D1%85%D0%BE%D0%B4%D0%BD%D1%8B%D1%85-%D0%BF%D0%B0%D1%80%D0%B0%D0%BC%D0%B5%D1%82%D1%80%D0%BE%D0%B2

?>

const AppModel = {
    components: {
        MyCmpt,
        //cmpt: MyCmpt,
    },
    data() {
        return {
            val1: 'A',
            val2: 'B',
        };
    },
};

Vue.createApp(AppModel).mount('#app')

//app.mount('#editor')