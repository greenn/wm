<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

?>
<? if (0) { // TypeError: Vue is not a constructor ?>
    new Vue({
        el: '#app',
        data: {
            selected: ''
        }
    })
<? } ?>
<? if (0) { ?>
    Vue.createApp({
        el: '#app',
        data: {
            selected: ''
        }
    })
<? } ?>

const app = Vue.createApp({
    data: function(){
        return {
            selected: ''
        }
    }
})

app.mount('#app');


//app.mount('#app');