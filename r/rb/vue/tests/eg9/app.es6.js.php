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
const { createApp } = Vue
const { createVuetify } = Vuetify

const vuetify = createVuetify()

const app = createApp({
    template: '#app-template',
    data: () => ({
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
}),

    computed: {
    radius () {
        let rounded = 'rounded'
        const value = this.rounded[this.model]

        if (value !== 'md') {
            rounded += `-${value}`
        }

        return rounded
    },
},
}).use(vuetify).mount('#app')