_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        _vue: {},

        data: function(){

            var label = {
                text: 'Фильтер',
                hover: false,
            };
            //var _label = Vue.reactive(label);
            //_log('reactive', _label, _label === label)

            return {
                label: label,
                buttons: _.transform({
                    'log': {},
                    'error': {},
                    'msg': {
                        selected: true
                    }
                }, function(res, item, key){
                    item.text = key;
                    res.push(item);
                }, []),
            }
        },
        computed: {
            hasFilter: function(){
                _log('c:hasFilter', this.buttons);
                return false;
            }
        },
        methods: {
            onButtonPress: function(button, isSelected){
                _log('buttonPress');
                //_.find(this.buttons, function(item){ return item === button; })
                _.each(this.buttons, function(item){
                    if (item === button) {
                        _log('select', item);
                        item.selected = isSelected;
                    }
                })


            }
        },
        watch: {},
        mounted: function() {}
    }
})