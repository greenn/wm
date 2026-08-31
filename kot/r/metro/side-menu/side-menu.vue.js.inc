<?
$Self = _kot::self()
?>
_vue('side-menu', function(_log, _cmd){

    _cmd.counter = 1; // для повторяющихся компонентов

    return {
        _vue: {
            provide: [
                'link',
                'applyParentMethod',
            ],
        },

        props: ['list'],

        data(){
            var listData = this.$props.list;

            return {
                _index: _cmd.curIndex(),
                //list: listData || [],
                //list: this.$props.list,
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
                if (this.noClick(item)) return;
                //_log('menuClick', { item: _cc(item) })
                if (item.sub) {
                    this.expand(item);
                } else {
                    //item.selected = true;
                    this.link(item.link);
                    this.applyParentMethod('side-pane', 'selectMenu', item);
                }
            },

            noLink: function(item){
                return !item.name;
            },

            noClick: function(item){
                return !item.sub && this.noLink(item);
            }

        },



        mounted(){
            //_log.index = this._index; //-  для повторяющихся компонентов
            //this.log = _log;

            if(0) this._log('mounted', { index: this._index,
                '$parent': this.$parent,
                '$parent/name': this.$parent._name,
                'this.$refs': this.$refs,
            });


        },
    }
})