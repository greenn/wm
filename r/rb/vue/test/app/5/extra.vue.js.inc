X2 = 200;
//console.log('##', '<?=__FILE__?>');

_vue('extra', function(_log){

    return {
        data(){
            _log('data');
            return {
                value: '-extra-'
            }
        },

        methods: {

        },

        mounted(){ _log('mounted'); },
        created(){ _log('created'); },
        beforeMount(){ _log('beforeMount'); },
    }
})