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
    // will match everything and put it under `$route.params.pathMatch`
    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
    // will match anything starting with `/user-` and put it under `$route.params.afterUser`
    { path: '/user-:afterUser(.*)', component: UserGeneric },
]

const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes: routes,
})


this.$router.push({
    name: 'NotFound',
    // preserve current path and remove the first char to avoid the target URL starting with `//`
    params: { pathMatch: this.$route.path.substring(1).split('/') },
    // preserve existing query and hash if any
    query: this.$route.query,
    hash: this.$route.hash,
})

const App = Vue.createApp({
    components: {}
})
App.use(router)
App.mount('#app')