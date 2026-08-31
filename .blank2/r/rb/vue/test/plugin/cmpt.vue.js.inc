_vue('v-cmpt', function(_log, _cmd){
    _cmd.counter = 1; // для повторяющихся компонентов
    return {
        template: '#v-cmpt',
        data: function(){
            return {
                _index: _cmd.curIndex(), //-  для повторяющихся компонентов
                value: 'cmpt-value'
            }
        },
        mounted: function() {
            _log.index = this._index; //-  для повторяющихся компонентов
            this._log('mounted', { 'this.$plugin': this.$plugin })
            this.$plugin.msg('cmpt ' + this._index + ' - <b>mounted</b>')
        }
    }
})