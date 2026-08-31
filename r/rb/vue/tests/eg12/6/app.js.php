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

const User = {
    template: `
    <div class="user">
      <h2>User {{ $route.params.username }}</h2>
      <router-view></router-view>
    </div>
  `,
}

const routes = [
    {
        path: '/user/:username',
        name: 'user',
        component: User
    }
]


const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes: routes,
})




const App = Vue.createApp({
    //components: {}
})


//router.resolve({ name: 'chapters', params: { chapters: ['a', 'b'] } }).href
// produces /a/b



router.push({ name: 'user', params: { username: 'erina' } })

App.use(router)
App.mount('#app')