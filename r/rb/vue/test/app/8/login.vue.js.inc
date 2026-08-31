_vue('login', function(_log){

    return {
        data(){
            //_log('data');
            return {
                content: '- L o g i n -'
            }
        },

        methods: {

        },

        mounted(){
            //log('mounted');
        },

        computed: {
            isActive(){
                return false;
                //log('mounted');
            },
        }
    }
})