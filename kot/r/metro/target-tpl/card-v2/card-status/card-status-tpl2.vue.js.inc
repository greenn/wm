<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                { 'v2-target-tpl2': {
                    self: {
                        select: { api: 'selectCardStatus_getOptions' }
                    }
                } }
            ],
        },

    }
})