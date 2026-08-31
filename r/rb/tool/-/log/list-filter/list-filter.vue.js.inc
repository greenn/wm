_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        _vue: {},

        data: function(){
            var _self = this;

            var list = _.transform({
                'log': {},
                'error': {},
                'msg': {}
            }, function(res, item, name){

                item.text = name;
                item.selected = false;

                item.relate = function(){
                    _self.trigger++;
                    //_self.$forceUpdate();
                }

                item.press = function(button){
                    //_log('press', button);
                    item.selected = !item.selected;
                    item.relate()
                };

                res.push(item);
            }, [])

            var label = {
                text: 'Фильтер',
                hover: false,
            };

            return {
                trigger: 0,
                label: label,
                buttons: list,
            }
        },
        computed: {
            hasFilter: function(){
                this.trigger;
                _log('c:hasFilter');
                return _.reduce(this.buttons, function(res, item){
                    return res + item.selected;
                }, false)
            }
        },
        methods: {},
        watch: {},
        mounted: function() {}
    }
})