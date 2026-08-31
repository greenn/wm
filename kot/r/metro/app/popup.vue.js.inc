<?
    $Self = _kot::self()
?>
_vue('popup', function(_log, _cmd){
    return {
        _vue: {
            //multiInstances: true,
        },
        //props: ['headline', 'msg'],
        //emits: ['submit'],
        data(){
            return {
                headline: false,
                msg: false,

                visible: false,
                cancel: {},
                submit: {},
            }
        },
        methods: {
            content: function(ctx){
                var self = this;


                this.headline = ctx.headline;
                this.msg = ctx.msg;

                var use_cb = function(cb){
                    return function(){
                        var close = function(){
                            _delay(0, function(){
                                self.visible = false
                            })
                        }

                        var autoClose = true;
                        if (cb) {
                            var cbRes = cb(close, self);
                            if (cbRes === false) autoClose = false;
                        }
                        if (autoClose) {
                            //_log('autoClose')
                            close()
                        }
                    }
                };

                if (!ctx.cancel) ctx.cancel = {}
                if (!ctx.submit) ctx.submit = {}

                this.cancel = {
                    title: ctx.cancel.title || 'Отмена',
                    click: use_cb(ctx.cancel.click)
                };

                this.submit = {
                    title: ctx.submit.title || 'Выполнить',
                    click: use_cb(ctx.submit.click)
                };

                _delay(10, function(){ //pk delay
                    self.visible = true;
                })
                //this.visible = true;
            }
        },
        mounted(){
            //test
            //this.showSuccess();
            //this.showError();
        }
    }
})