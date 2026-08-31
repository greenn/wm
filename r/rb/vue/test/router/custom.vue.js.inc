<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'id' => $Self::nc()
));
$id = $_ctx['id'];
?>
_vue('<?=$id?>', function(_log, _cmd){

    return {
        template: '#<?=$id?>',

        //created(){ this._log.changeBaseTitle('<?=$id?>') },


        data: function(){
            return {
                name: '<?=$id?>',
                content: '',
            }
        },

        methods: {},

        mounted: function() {}
    }
})