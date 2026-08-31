<?
$Self = _rw::name('tool-man');
$_ctx = $Self::tempCtx(array(
	'id' => $Self::nc()
));
$id = $_ctx['id'];
?>
_vue('<?=$id?>', function(_log, _cmd){
    return {
        _vue: {},
        inheritAttrs: false,
        data: function(){

            _log('mounted', {

                props: _clearObject(this.$props),

                attrs: _clearObject(this.$attrs),

            });

            return {}
        },
        mounted: function() { _log('mounted') }
    }
})