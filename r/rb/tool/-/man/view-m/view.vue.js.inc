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
        data: function(){ return {} },
        mounted: function() { _log('mounted') }
    }
})