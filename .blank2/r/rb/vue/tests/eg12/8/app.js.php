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


#== https://router.vuejs.org/ru/guide/advanced/navigation-guards.html#%D1%85%D1%83%D0%BA%D0%B8-%D0%B4%D0%BB%D1%8F-%D0%BA%D0%BE%D0%BD%D0%BA%D1%80%D0%B5%D1%82%D0%BD%D1%8B%D1%85-%D0%BA%D0%BE%D0%BC%D0%BF%D0%BE%D0%BD%D0%B5%D0%BD%D1%82%D0%BE%D0%B2

?>

const Foo = {
    template: `...`,
    beforeRouteEnter(to, from, next) {
        // вызывается до подтверждения пути, соответствующего этому компоненту.
        // НЕ ИМЕЕТ доступа к контексту экземпляра компонента `this`,
        // так как к моменту вызова экземпляр ещё не создан!
    },
    beforeRouteUpdate(to, from, next) {
        // вызывается когда маршрут, что рендерит этот компонент изменился,
        // но этот компонент будет повторно использован в новом маршруте.
        // Например, для маршрута с динамическими параметрами `/foo/:id`, когда мы
        // перемещаемся между `/foo/1` и `/foo/2`, экземпляр того же компонента `Foo`
        // будет использован повторно, и этот хук будет вызван когда это случится.
        // Также имеется доступ в `this` к экземпляру компонента.
    },
    beforeRouteLeave(to, from, next) {
        // вызывается перед переходом от пути, соответствующего текущему компоненту;
        // имеет доступ к контексту экземпляра компонента `this`.
    }
}



const routes = [
    {
        path: '/settings',
        // You could also have named views at the top
        component: UserSettings,
        children: [
            {
                path: 'emails',
                component: UserEmailsSubscriptions
            },
            {
                path: 'profile',
                components: {
                    default: UserProfile,
                    helper: UserProfilePreview
                }
            }
        ]
    }
]



const router = VueRouter.createRouter({
    history: VueRouter.createWebHashHistory(),
    routes: [
        {
            path: '/',
            components: {
                default: Home,
                // short for LeftSidebar: LeftSidebar
                LeftSidebar,
                // they match the `name` attribute on `<router-view>`
                RightSidebar,
            },
        },
    ],
})


const App = Vue.createApp({
    //components: {}
})


//router.resolve({ name: 'chapters', params: { chapters: ['a', 'b'] } }).href
// produces /a/b



router.push({ name: 'user', params: { username: 'erina' } })

App.use(router)
App.mount('#app')