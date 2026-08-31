<?
$Self = _kmod::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [
                //{ 'linkRel': '<?=kot('hp', 'namedUrl', 'blank')?>' }
            ],

        },

        data(){
            //_log('data');
            return {
                items: [],
                flagLoad: false,
                flagToggle: false,
            }
        },

        methods: {
            loadItems(){
                ApiKMod.assignArray({
                    dbg: 1,
                    api: 'blank/list',
                    this: this, //responseProp: 'list', resProp: 'list',
                    busy: [this, 'flagLoad'],
                    resProp: 'items',
                    //cbRes: this.rootInit
                });
            }
        },

        mounted(){
            //_log('mounted')
        },
    }
})