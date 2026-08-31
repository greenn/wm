<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'id' => $Self::nc()
));
$id = $_ctx['id'];
?>
_vue('<?=$id?>', function(_log, _cmd){
    _cmd.counter = 1; // для повторяющихся компонентов
    return {
        template: '#<?=$id?>',
        data: function(){
            return {
                _index: _cmd.curIndex(), //-  для повторяющихся компонентов
                _name: '<?=$id?>'
            }
        },

        computed: {
            name: function(){
                return [this._name, this._index].join('-');
            }
        },
        mounted: function() {
            _log.index = this._index; //-  для повторяющихся компонентов
        }
    }
})