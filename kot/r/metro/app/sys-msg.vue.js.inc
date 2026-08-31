<?
    $Self = _kot::self()
?>
_vue('sys-msg', function(_log, _cmd){
    var tmShow = _r.msgTimeout;
    return {
        _vue: {
            //multiInstances: true,
        },
        props: [],
        data(){
            return {
                list: []
            }
        },
        methods: {
            showItem: function(item){
                var self = this;
                item.index = this.list.length;

                item.delete = function(){
                    delete self.list[item.index];
                }

                var run_autoclose = function(time){
                    item.start_time = Date.now();
                    item.timeout = setTimeout(function(){
                        item.delete();
                    }, time)
                }

                item._hover = false;
                item.hover = function(state){
                    //_log(`hover/${item.index}`, state, { item, pass: Date.now() - item.start_time })
                    item._hover = state;
                    if (state) {
                        clearTimeout(item.timeout);
                    } else {
                        var pass = Date.now() - item.start_time;
                        //_log('hover/continue - left = ', 3000 - pass)
                        run_autoclose(tmShow - pass)
                    }
                };

                item._stop = false;
                item.stop = function(){
                    item._stop = true;
                    clearTimeout(item.timeout);
                }

                this.list.push(item);
                run_autoclose(tmShow)
            },

            showSuccess: function(msg/*|title, msg*/){
                var title = 'Успех';
                if (!msg) msg = 'Операция выполнена успешна';
                if (arguments.length === 2) {
                    title = arguments[0];
                    msg = arguments[1];
                }

                this.showItem({
                    typeNc: '-success',
                    typeTitle: title,
                    typeMsg: msg,
                })
            },

            showError: function(msg/*|title, msg*/){
                var title = 'Ошибка';
                if (!msg) msg = 'Сервен вернул ошибку';
                if (arguments.length === 2) {
                    title = arguments[0];
                    msg = arguments[1];
                }
                this.showItem({
                    typeNc: '-error',
                    typeTitle: title,
                    typeMsg: msg,
                })
            },
        },
        mounted(){
            //test
            //this.showSuccess();
            //this.showError();
        }
    }
})