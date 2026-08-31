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
        ],

        data(){
            return {
                stations: {},
                busy: false,
            }
        },

        methods: {
            getStationTitle(id){
                var station = this.stations && this.stations[id];
                return station ? station.text : '-';
            }
        },

        mounted(){
            var self = this;
            _r('ui', 'selectStation_getOptions', {
                busy: [this, 'busy'],
                next: function(options, stations){
                    self.stations = stations;
                }
            });
        },
    }
})