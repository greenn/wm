<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();

//$Self::req_vue('tpl2-passes-qy');
$Self::req_vue('passes/tpl2-station-freq', array(), 'tpl2-passes--station-freq');
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [],
        },

        props: [
            'targets',
            //'forecast', 'busyCoverage',
            'toggler' //dbg
        ],
        //emits: ['onCalcCoverage'],

        data(){
            return {}
        },

        methods: {

            addRef(ref, item){
                if (!item.ref) item.ref = ref;
            },

            calcCoverage: function(item){
                //_log('calcCoverage', { targets: _cc(this.targets) })

                _.each(this.targets, function(item){
                    if (item.ref) {
                        item.ref.calcCoverage()
                    }
                })
            }

        },

        watch: {
            targets: {
                deep: true,
                handler: function(list){
                    //_log('w:targets', { list: _cc(list) });
                }
            },
        },

        mounted() {
            //_log('mounted', { targets: _cc(this.targets) });
        }
    }
})