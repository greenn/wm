<?
$Self = _rt::name('app-busy');
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
//admin-r-kmod
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            //provide: [],
            //store: [], //_store: {}
        },

        props: [],
        data(){
            return {
                busy: {
                    api: false,
                }
            }
        },

        methods: {},
        computed: {
            isBusy(){
                var self = this;
                var busyData = this.busy;
                return function(prop) {
                    return prop ? busyData[prop] : _.some(busyData, Boolean);
                }
            },
        },

        mounted(){
            this._log('mounted');
        },
    }
})