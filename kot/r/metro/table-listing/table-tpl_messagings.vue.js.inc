<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){
    return {
        _vue: {
            multiInstances: true,
            provide: [
                { 'linkRel': '<?=_kot::namedUrl('tmsgs')?>' },
            ],
        },

        props: ['items'],

        data(){
            return {
                modals: [],
                tr_selected: undefined,
                busy: false,
            }
        },

        //methods: {},

        computed: {
            totalItems: function(){
                return this.items.length
            }
        },

        mounted(){
            //_log('mounted', { items: _cc(this.items) });
        },
    }
})