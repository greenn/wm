<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
        },

        emits: [
            'onToggle'
        ],

        data(){
            //_log('data');
            return {
                spinnerPic: '<?=kot_i::uri('spinner/ava-load/3dgifmaker61330.gif')?>',
                //spinnerPic: '<?=kot_i::uri('logo/3/90.png')?>',
                load: false,
                info: {},
            }
        },

        methods: {
            spinnerPreload(){
                const img = new Image();
                img.src = this.spinnerPic;

            }
        },

        mounted(){
            this.spinnerPreload();

            var self = this;
            ApiKot.assignArray({
                //dbg: 1,
                api: 'app-user/snippet-info.get', //data: {},
                this: this, responseProp: 'info', resProp: 'info',
                busy: [this, 'load'],
                cbRes: function(){
                    //_log('dataLoadRes', { self: this, arguments, info: _cc(self.info) })
                }
            });


        },
    }
})