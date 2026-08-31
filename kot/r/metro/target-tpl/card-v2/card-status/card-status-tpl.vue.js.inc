<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
	            <? if (true && 'v1') { ?>
                    { 'v2-target-tpl': {
                        'd:data': {
                            interval: true
                        },
                        loadOptions: {
                            fn: 'selectCardFactor_getOptions'
                        }
                    } }

                <? } else { //v2 ?>
                    { 'v2-target-tpl': {
                        self: {
                            interval: { api: 'selectCardFactor_getOptions' }
                        }
                    } }
	            <? } ?>
            ],
        },
    }
})