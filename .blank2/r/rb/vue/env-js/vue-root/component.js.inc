<? $js ?>
__root.getComponent = function(cmptName){
    _log('getComponent', cmptName);
    var cmpt = _list[cmptName]
    return cmpt;
}

//ak saveMountedComponent / addComponentLink
__root.saveComponent = function(name, self){
    //_log('saveComponent', { name, self, index: self._index });

    if (self._index) {
        name = `${name}[${self._index}]`;

    }
    //self.log('saveComponent');
    _list[self._name] = self;
}


<? include $js['vue_root/addComponent']; //__root.addComponent() ?>

<? include $js['vue_root/loadComponent']; //__root.loadComponent() ?>

<? include $js['vue_root/componentCall']; //__root.componentCall() ?>