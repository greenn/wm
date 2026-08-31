<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){
    return {
        _vue: {
            provide: [],
        },
        props: [
            'hasSubTitle'
        ],
        mounted(){
            if(0) _log('mounted', {
                slots: _cc(this.$slots),
                slotCmd: _cc(this.$slots.cmd),
                slotCmdL: this.$slots.cmd.length,
            })
        }
    }
})