<?
/*
    составляющшие ресурса
        показываем
        редактируем
*/
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            //provide: [],
            //store: [],
            //_store: {}
        },

        props: [
            'name'
        ],
        data(){
            return {
                list: []
            }
        },

        methods: {

            syncStruct(){
                var self = this;

                self.busy
                ApiKot.get('admin-r/r-struct', {
                    name: self.name,
                }, function(response){
                    //_log('eat/result', { response })
                    self.li.eat = false;
                })

            },


        },

        mounted(){
            if(1) _log('mounted', {
                'vue-name': '<?=$vueName?>',
                'self-url': '<?=kot('hp', 'namedUrl', $vueName)?>',
            })


        },
    }
})