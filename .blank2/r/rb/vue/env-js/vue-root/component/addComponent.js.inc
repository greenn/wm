
__root.addComponent = function(name, decl){

    if (App) {
        App.component(name, decl);
    }

	<? if (!1) { ?>
        VueDecl.extendCallback('beforeMount', decl, function(){
            __root.saveComponent(name, this);
        });
	<? } else { ?>
        VueDecl.extendCallback('mounted', decl, function(){
            __root.saveComponent(name, this);
        });
	<? } ?>

    <? if (0) { //prev ?>
        //if (_.startsWith(name, 'target-form')) _log('addComponent01', { name });
        VueDecl.extendCallback('mounted', decl, function(){
            //_log('mounted-a/saveComponent', { name });
            //this.__ = __self;

            __root.saveComponent(name, this);

            //#P1
            if (_.startsWith(name, 'target-form')) _log('addComponent02', {
                name, self: this, _name: this._name,
                '_list[this._name]': _list[this._name]
            });
        });
	<? } ?>

    _log('addComponent', { name, decl, _list, _decl})
}
