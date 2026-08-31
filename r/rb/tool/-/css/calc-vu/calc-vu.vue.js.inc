_vue('calc-vu', function(_log, _cmd){
    //_cmd.counter = 1; // для повторяющихся компонентов

    return {
        _vue: {
            store: {
                keys: ['input', 'size'],
                //propIndex: '_index' //_storeIndex -  для повторяющихся компонентов
            }
        },

        data: function(){
            return {
                //_index: _cmd.curIndex(), //-  для повторяющихся компонентов
                input: '',
                size: window.screen.width,
            }
        },
        computed: {
            value: function(){
                var val = this.input / this.size * 100;
                return val.toFixed(2);
            }
        },
        methods: {},
        watch: {
            input: function(){
                //_log.index = this._index;
                _log('w:input', arguments);
            }
        },
        mounted: function() {
            //_log.index = this._index; //-  для повторяющихся компонентов
            //_log('mounted', { this: this, arguments: arguments })
        }
    }
})