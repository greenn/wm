<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                { 'v2-target-tpl': {
                    list: { api: 'selectCardFactor_getOptions' }
                } }
            ],
        },
    }
})