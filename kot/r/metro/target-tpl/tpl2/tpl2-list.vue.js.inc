<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        props: [
            'label',
            'list',
            'info',
            'busy',
        ],

        data(){
            return {}
        },

        methods: {
            valueTitle(value){
                return _.get(this, ['info', value, 'text'], '-');
            },
        },

        <?/*computed: {
            titleList(){
                var self = this;
                return _.transform(this.list, function(res, id){
                    _log('c:titleList/each', { id })
                    res.push(self.valueTitle(id))
                }, [])
            }
        },*/?>

        watch: {},

        mounted(){},
    }
})