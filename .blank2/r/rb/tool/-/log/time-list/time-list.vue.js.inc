<?
//$Self = _rw::name($self_nc = 'tool-log');
//$_ctx = $Self::tempCtx(); //$vue_name = $_ctx['id']
$vue_name = basename(__FILE__, '.vue.js.inc');
?>
_vue('<?=$vue_name?>', function(_log, _cmd){
    //var startTime = <?=microtime(true)?>;
    //_log('startTime', startTime);
    return {
        _vue: {},
        props: ['logData'],

        data: function(){
            return {
                //listKeys: {},
                //stack: [],
                //lastTime: startTime
            }
        },
        computed: {
            list: function(){
                var self = this;
                var list = [];
                //list = {};
                var logData = this.logData;
                _.each(logData, function(data, key){
                    var mStartTime = moment(key * 1000);
                    var rec = {
                        open: false,
                        url: data.uri,
                        date: mStartTime.format('MMM-DD HH:mm:ss'), //'YYYY/MMM/DD HH:mm:ss'
                        items: _.each(data.items, function(item, index){
                            var _time = moment(item.time * 1000).diff(mStartTime);
                            var _format = 'ss.SSS';
                            if (_time > 60*1000) _format = 'mm:' + _format;
                            if (_time > 60*1000 * 60) _format = 'HH:' + _format;
                            item.passedTime = moment(_time).utc().format(_format);

                            item.open = true
                        })
                    }
                    list.unshift(rec);
                    //list[key] = rec;
                })
                //_log('c:list', { list, logData: logData })
                return list;
            }
        },
        methods: {},
        watch: {},
        mounted: function() {}
    }
})