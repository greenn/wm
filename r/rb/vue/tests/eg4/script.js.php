<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

?>1

const TodoItem1 = {
    template: `
        <li>Это одна из задач</li>
    `
}



var App = Vue.createApp({
    data: function() {
        return {
            message: 'Hello Vue!',
            title: 'Страница загружена ' + new Date().toLocaleString(),
            counter: 0,

            //click: function(){},

            visible: true,

            todos: [
                { text: 'Learn JavaScript' },
                { text: 'Learn Vue' },
                { text: 'Build something awesome' }
            ],


            groceryList: [
                { id: 0, text: 'Vegetables' },
                { id: 1, text: 'Cheese' },
                { id: 2, text: 'Whatever else humans are supposed to eat' }
            ]

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
        },

        toggleVisible: function(){
            console.log('click', [this.visible]);
        },

        isVisible: function(){
            console.log('isVisible', [this.visible]);
            return this.visible === true;
        },
    },

    components: {
        TodoItem1: TodoItem1, // Регистрируем новый компонент
        //TodoItem2: TodoItem2, // Регистрируем новый компонент
    },

    mounted: function() {
        var self = this;

        setInterval(function(){
            self.counter++
        }, 1000)
    }
});
//App.mount('#hello-vue');


App.component('blog-post', {
    props: ['title'],
    template: `<h4>{{ title }}</h4>`
})

App.component('todo-item2', {
    props: ['todo'],
    template: `<li>{{ todo.text }}</li>`
})


App.mount('#app');
