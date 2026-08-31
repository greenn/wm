<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'//,
	//'dirUrl'
);

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

//$dirUri = dirUrl(__FILE__);


#== https://v3.ru.vuejs.org/ru/examples/markdown.html

?>
const app = Vue.createApp({
    data() {
        return {
            input: '# hello'
        }
    },
    computed: {
        compiledMarkdown() {
            return marked(this.input, { sanitize: true });
        }
    },
    methods: {
        update: _.debounce(function(e) {
            this.input = e.target.value;
        }, 300)
    }
})

app.mount('#editor')