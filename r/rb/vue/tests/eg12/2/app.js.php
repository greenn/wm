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

?>
const User_v1 = {
    template: '<div>User {{ $route.params.id }}</div>',
}

const User_v2 = {
    template: '<div>User {{ $route.params.username }} / post: {{ $route.params.postId }}</div>',
}

const User_v3 = {
    template: '<div>User {{ $route.params.id }}</div>',
    created: function(){
        var _this = this;
        _this.$watch(
            function(){
                return _this.$route.params
            },
            function (toParams, previousParams) {
                // react to route changes...
            }
        )
    },
    beforeRouteUpdate: async function beforeRouteUpdate(to, from) {
        // react to route changes...
        this.userData = await fetchUser(to.params.id);
    }
}


// these are passed to `createRouter`
const routes = [
    // dynamic segments start with a colon
    //{ path: '/users/:id', component: User_v1 },
    //{ path: '/users/:username/posts/:postId', component: User_v2 },
    { path: '/users/:id', component: User_v3 },
]


const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes: routes,
})


const App = Vue.createApp({
    components: {}
})
App.use(router)
App.mount('#app')