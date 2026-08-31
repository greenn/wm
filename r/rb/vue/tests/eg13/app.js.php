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


#== https://v3.ru.vuejs.org/ru/guide/routing.html#%D1%81%D0%BE%D0%B7%D0%B4%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BF%D1%80%D0%BE%D1%81%D1%82%D0%BE%D0%B8-%D0%BC%D0%B0%D1%80%D1%88%D1%80%D1%83%D1%82%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D0%B8-%D1%81-%D0%BD%D1%83%D0%BB%D1%8F

?>
const { createApp, h } = Vue

const NotFoundComponent = { template: '<p>Страница не найдена</p>' }
const HomeComponent = { template: '<p>Главная страница</p>' }
const AboutComponent = { template: '<p>Страница о нас</p>' }

const routes = {
    '/': HomeComponent,
    '/about': AboutComponent
}

const SimpleRouter = {
        data: () => ({
        currentRoute: window.location.pathname
    }),

    computed: {
        CurrentComponent() {
            return routes[this.currentRoute] || NotFoundComponent
        }
    },

    render() {
        return h(this.CurrentComponent)
    }
})

createApp(SimpleRouter).mount('#app')

