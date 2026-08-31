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

const Home = { template: '<div>Home</div>' }
const About = { template: '<div>About</div>' }





const App = Vue.createApp({
    components: {

    }
})

    //dd-er
    var blogPost = App.component('blog-post', {
        props: ['title'],
        template: `<h4>test: {{ username }}</h4>`,

        computed: {
            username: function () {
                // We will see what `params` is shortly
                return this.$route.params.username
            },
        },

        methods: {
            goToDashboard() {
                if (isAuthenticated) {
                    this.$router.push('/dashboard')
                } else {
                    this.$router.push('/login')
                }
            },
        },
    });

const routes = [
    { path: '/', component: Home },
    { path: '/about', component: About },
    { path: '/test', component: App.component('blog-post') }
]

const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(),
    routes: routes,
})



App.use(router)

console.log(App.component('blog-post'));

/*routes.push(
    { path: '/test', component: App.component('blog-post') }
);*/

App.mount('#app')