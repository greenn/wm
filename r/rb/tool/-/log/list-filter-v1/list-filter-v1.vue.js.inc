_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        _vue: {},

        data: function(){
            var _self = this;
            var list = _.each({
                'log': {},
                'error': {},
                'msg': {}
            }, function(item, name){

                item.text = name;
                item.selected = false;

                item.relate = function(){
                    //_log('??', { '$data': _self.$data, '$data.set': _self.$data.set })
                    //_log('??', { 'buttons.set': _self.buttons.__proto__ })
                    _self.trigger++;
                    _self.$forceUpdate();
                    //Vue.triggerRef(_self.buttons)
                    //q Vue.triggerRef(item)

                    //_self.$data.set(this, 'buttons', list)
                    //Vue.set(this, 'buttons', list)
                    //_self.buttons = list;
                    //
                }

                item.press = function(button){
                    //_log('press', button);
                    item.selected = !item.selected;
                    item.relate()
                };
            })

            var resList = Vue.reactive(list);
            _log('?', [list, resList, resList === list,]);

            //var refList = Vue.ref(list);
            var refList = Vue.shallowRef(list);
            _log('?ref', { ref: refList });

            var label = {
                text: 'Фильтер',
                hover: false,
            };

            var _label = Vue.reactive(label);
            _log('reactive', _label, _label === label)
            return {
                trigger: 0,
                label: label,
                //buttons: Vue.reactive(list)
                //buttons: resList,
                //buttons: refList,
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