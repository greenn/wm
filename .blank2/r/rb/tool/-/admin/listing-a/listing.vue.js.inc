<?
$Self = _rw::name('tool-admin');
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

            if (0) _log('data', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
            });

            return {
                sd: this.$attrs.sd,
                list: []
            }
        },

        methods: {
            updateItem: function(id, itemData){

                var idx = _.findIndex(this.list, ['id', id]);
                _log('updateItem', { id, itemData, idx, 'idx-item': this.list[idx] })
                Object.assign(this.list[idx], itemData)
            },

            addItem: function(itemData){ //addItemData|addItem
                _log('addItem', { itemData })
                this.list.push(itemData);
            },

            removeItem: function(itemId){
                _log('removeItem', { itemId, list: this.list })
                var l0 = this.list.length;
                _.remove(this.list, { id: +itemId });
                //_.remove(this.list, function(item){ return item.id == itemId });
                //_log('removeItem-after', { 'list-length': [l0, this.list.length] })
            },
        },
        mounted: function() {
            var self = this;
            if (this.$parent.regView) this.$parent.regView(this, 'listing')

            //_log('mounted');
            //_api('sd', 'list')
            api.sd_list(this.sd, function(response){
                self.list = response.list;
                _log('mounted/api', { response })
            })

        }
    }
})