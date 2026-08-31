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
            posts: [
                { id: 1, title: 'My journey with Vue' },
                { id: 2, title: 'Blogging with Vue' },
                { id: 3, title: 'Why Vue is so fun' }
            ],
            postFontSize: 1
        }
    }
})

app.component('button-counter', {
    data: function() {
        return {
            count: 0
        }
    },

    template: `
        <button @click="count++">
          Счётчик кликов — {{ count }}
        </button>
    `
})

app.component('blog-post', {
    props: ['title'],
    emits: ['enlargeText'],
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
        <div class="blog-post">
          <h4>{{ title }}</h4>
          <button @click="$emit('enlargeText')" title="envoke enlargeText">
            $emit('enlargeText')
          </button>
        </div>
    `
})

app.mount('#app');