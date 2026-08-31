<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>

_Store = (function (){
    var _log = Log.for('Vuex');
    return new Vuex.Store({
        state: {
            list: []
        },

        actions: {
            loadList(ctx){
                var list = [];
                list.push({ text: '111' });
                list.push({ text: '112' });
                list.push({ text: '113' });

                //dispatch('sayHello', ctx.getters.getList);
                ctx.commit('setList', list)
            },
        },

        mutations: {
            //функции, которые напрямую будут изменять store

            setList(state, list){

                state.list = list;
                _log('setList', list);

            },

            createPost(state, item){
                //state.list.push(item);
                state.list.unshift(item);
            },
        },

        getters: {
            //позволяет трансформировать и получать данные из store
            getList(state){
                return state.list;
            }
        },

        modules: {}
    });
})()

vue_app(function(_log){

    return {
        data: function(){
            return {
                h1: 'Vuex',
            }
        },
        mounted(){
            //_log('mounted', { 'this.$store': this.$store, _Store: _Store })
            this.$store.dispatch('loadList');

        }
    }

}, {
    sr: '#app',
    beforeMount: function(_log){
        _App.use(_Store);
    }
})