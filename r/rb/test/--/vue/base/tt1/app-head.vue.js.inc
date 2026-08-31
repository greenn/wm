<?
$Self = _rt::name('test-vue-base-tt1');

$_ctx = $Self::tempCtx(array(
	'id' => basename(__FILE__, '.vue.js.inc')
));
$vueName = $_ctx['id'];
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        //props: ['value'],
        //emits: ['update:value'],
        data(){
            return {
                tplName: '<?=$vueName?>'
            }
        },

        mounted(){
            _log('mounted')
        },
    }
})