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

const routes = [
    // matches /o/3549
    { path: '/o/:orderId' },
    // matches /p/books
    { path: '/p/:productName' },
]

const routes = [
    // /:orderId -> matches only numbers
    { path: '/:orderId(\\d+)' },
    // /:productName -> matches anything else
    { path: '/:productName' },
]

const routes = [
    // /:chapters -> matches /one, /one/two, /one/two/three, etc
    { path: '/:chapters+' },
    // /:chapters -> matches /, /one, /one/two, /one/two/three, etc
    { path: '/:chapters*' },
]

const routes = [
    // only match numbers
    // matches /1, /1/2, etc
    { path: '/:chapters(\\d+)+' },
    // matches /, /1, /1/2, etc
    { path: '/:chapters(\\d+)*' },
]

const routes = [
    // will match /users and /users/posva
    { path: '/users/:userId?' },
    // will match /users and /users/42
    { path: '/users/:userId(\\d+)?' },
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