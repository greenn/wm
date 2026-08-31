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
      <h2>User {{ $route.params.id }}</h2>
      <router-view></router-view>
    </div>
  `,
}


// these are passed to `createRouter`
const routes = [{ path: '/user/:id', component: User }]

const routes = [
    {
        path: '/user/:id',
        component: User,
        children: [
            {
                // UserProfile will be rendered inside User's <router-view>
                // when /user/:id/profile is matched
                path: 'profile',
                component: UserProfile,
            },
            {
                // UserPosts will be rendered inside User's <router-view>
                // when /user/:id/posts is matched
                path: 'posts',
                component: UserPosts,
            },
        ],
    },
]

const routes = [
    {
        path: '/user/:id',
        component: User,
        children: [
            // UserHome will be rendered inside User's <router-view>
            // when /user/:id is matched
            { path: '', component: UserHome },

            // ...other sub routes
        ],
    },
]


const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes: routes,
})


// given { path: '/:chapters*', name: 'chapters' },
router.resolve({ name: 'chapters', params: { chapters: [] } }).href
// produces /
router.resolve({ name: 'chapters', params: { chapters: ['a', 'b'] } }).href
// produces /a/b

// given { path: '/:chapters+', name: 'chapters' },
router.resolve({ name: 'chapters', params: { chapters: [] } }).href
// throws an Error because `chapters` is empty

/*
this.$router.push({
    name: 'NotFound',
    // preserve current path and remove the first char to avoid the target URL starting with `//`
    params: { pathMatch: this.$route.path.substring(1).split('/') },
    // preserve existing query and hash if any
    query: this.$route.query,
    hash: this.$route.hash,
})
*/


const App = Vue.createApp({
    components: {}
})
App.use(router)
App.mount('#app')