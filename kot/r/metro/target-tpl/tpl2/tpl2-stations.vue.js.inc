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
            'value',
            'mcd'
        ],

        data(){
            return {
                stations: {},
                busy: false,
            }
        },

        methods: {
            getStationTitle(item){
                var station = this.stations && this.stations[item.id];
                return station ? station.text : '-';
            }
        },

        mounted(){
            var self = this;
            //_log('mounted', { value: this.value });

            var api = this.mcd ? 'selectMcd_getOptions' : 'selectStation_getOptions';

            _r('ui', api, {
                busy: [this, 'busy'],
                next: function(options, stations){
                    self.stations = stations;
                }
            });
        },
    }
})