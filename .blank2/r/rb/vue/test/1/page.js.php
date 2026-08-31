<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'
);

$Self = _rt::self();
$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);
?>

    axios.defaults.baseURL = '<?=rt('api', 'apiUrl')?>';
    //axios.defaults.headers.post['Content-Type'] = 'application/json';

    axios.post('/test', {
        firstName: 'Fred',
        lastName: 'Flintstone'
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        })
    ;


    let Page;
    const _Page = Vue.createApp({
        data(){
            return {
                responseData: false,
            }
        },
        methods: {
            sendApi: function(){
                console.log('sendApi');
            }
        }
    })


$(function(){
    Page = _Page.mount('#page');
    console.log('Page', {
        _Page: _Page,
        Page: Page,
        //'_Page.$root': _Page.$root, //= empty
        //'Page.$root': Page.$root, //==

    })
})