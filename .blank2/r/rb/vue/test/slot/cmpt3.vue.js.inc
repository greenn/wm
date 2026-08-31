_vue('v-cmpt3', function(_log, _cmd){

    return {
        //template: '#v-cmpt3',
        data: function(){
            return {
                items: ['Покормить кота', 'Купить молока']
            }
        },
        mounted: function() {
            this._log('mounted')
        }
    }
})