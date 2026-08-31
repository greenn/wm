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


// Создаём приложение Vue
const app = Vue.createApp({
    data: function(){
        return {
            h1: 'text text text',
            postFontSize: 1
        }
    },

    methods: {
        doEnlargeText(enlargeAmount) {
            this.postFontSize += enlargeAmount
        }
    }
})

app.component('enlarge-button', {
    props: ['title'],
    //emits: ['enlargeText'],
    emits_: {
        click: null, // Без валидации,
        'enlarge-text': function (ctx) {
            console.log('blog-post', 'enlarge-text')
        },
        enlargeText_: function (ctx) {
            console.log({ ctx: ctx, args: arguments });
            console.warn('Некорректные данные для генерации события enlargeText!');
            //return false;

        }

    },
    template: `
        <button @click="$emit('enlargeText', 0.2)">enlarge 0.2</button>
    `
})


app.mount('#app');