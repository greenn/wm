<?
$Self = _kot::self();
$n = $Self::nc();
?>

_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                { 'linkRel': '<?=_kot::namedUrl('trg')?>' },
            ],
        },

        props: ['items'],

        data(){
            return {
                //head: th_list,
                //items: [],
                modals: [],
                tr_selected: undefined,
                busy: false,
                forecastBusy: false,
            }
        },

        methods: {},

        computed: {
            totalItems: function(){
                return this.items.length
            }
        },

        mounted(){},
    }
})