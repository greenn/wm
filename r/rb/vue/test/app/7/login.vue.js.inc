_vue('login', function(_log){

    return {
        _vue: {
            provide: [
                //'regField', 'regButton',
                'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

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