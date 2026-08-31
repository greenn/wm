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


#== https://codesandbox.io/s/nested-named-views-vue-router-4-examples-re9yl?&initialpath=%2Fsettings%2Femails

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