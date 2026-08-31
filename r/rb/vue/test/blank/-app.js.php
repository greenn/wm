vue_app(function(_log){
    _log('0');
    return {
        data: function(){ return {} },
        methods: {},
        watch: {},
        components: {},
        mounted: function() {
            //_log('mounted', _app('app'))
        }
    }

}, function(){

    App = _App.mount('#app');
})