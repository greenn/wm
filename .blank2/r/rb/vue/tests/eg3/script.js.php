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

var App = Vue.createApp({
    data: function() {
        return {
            message: 'Hello Vue!',
            title: 'Страница загружена ' + new Date().toLocaleString(),
            counter: 0,

            click: function(){}
        }
    },

    methods: {
        reverseMessage() {
            console.log('[reverseMessage()]', { this: this, args: arguments });
            console.dir(this);

            this.message = this.message
                .split('')
                .reverse()
                .join('')
        }
    },

    mounted: function() {
        var self = this;

        setInterval(function(){
            self.counter++
        }, 1000)
    }
});
//App.mount('#hello-vue');


App.mount('#app');
