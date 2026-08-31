<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();
?>
_vue('<?=$vueName?>', function(_log, _cmd){

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
                cfg: {
                    station: [],
                    'station-fix': true,

                    time1: '',
                    'time1-fix': true,
                },

                //ui-select
                stationOptions: [],
                stationBusy: false
            }
        },

        methods: {
            onStationData(optionsData){
                //_log('onStationData', optionsData);
                this.stationOptions = optionsData;
            }
        },

        mounted(){


        },
    }
})