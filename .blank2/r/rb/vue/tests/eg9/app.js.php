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

var app = Vue.createApp({
    template: '#app-template',
    data: function(){
        return {
            model: 3,
            rounded: [
                '0',
                'sm',
                'md',
                'lg',
                'xl',
                'pill',
                'circle',
            ],
        }
    },

    computed: {
        radius: function() {
            var rounded = 'rounded';
            var value = this.rounded[this.model];

            if (value !== 'md') {
                rounded += '-' + value;
            }

            return rounded
        },
    },

});

app.use(Vuetify.createVuetify());

app.mount('#app');