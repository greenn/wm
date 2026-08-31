<?
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));  //'side-menu'
?>
_vue('side-menu', function(_log, _cmd){

    _cmd.counter = 1; // для повторяющихся компонентов

    return {
        _vue: {
            provide: [
                'link',
                //'applyParentMethod',
            ],
        },

        props: [
            'list', //+en 'flag-что-будут-данные',
            'depth', //er
            'ftLink', //'ftSubLink',

            'mock', //wd
        ],

        data(){
            return {
                _index: _cmd.curIndex(),
                items: this.$props.list,
                expanded: false,
            }
        },

        methods: {
            expand: function(item){
                //this._log('expand', { item })
                //this._log('expand', { index: this._index, list: this.list });
                var oppositeValue = !item.expanded;
                item.expanded = oppositeValue;

                ///this._log('expand', { this: this, 'this.selectMenu': this.selectMenu });
            },

            menuClick: function(item){
                //if (this.noClick(item)) return;
                //_log('menuClick', { item: _cc(item) })

                if (item.sub) {
                    this.expand(item);
                } else {
                    //item.selected = true;
                    this.link(item.link);
                    this.applyParentMethod('side-pane', 'selectMenu', item);
                }
            },

            /*
                noLink: function(item){
                    return !item.name;
                },

                noClick: function(item){
                    return !item.sub && this.noLink(item);
                },


            hasLink: function(item){
                return !!item.name;
            },

            hasClick: function(item){
                return item.sub && this.hasLink(item);
            }

            */

        },



        mounted(){

            var self = this;

            if (!this.items) {
                ApiKot.assignArray({
                    //dbg: 1,
                    api: 'side-menu/v0/list', data: { mock: this.mock },
                    this: this, //responseProp: 'list', resProp: 'list',
                    resProp: 'items',
                    cbRes: function(){
                        //_log('dataLoadRes', { items: _cc(self.items) })
                    }
                });
            }


        },
    }
})