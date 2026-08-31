var RootDecl = function(extend, appName){
    var _log = Log.for('ROOTCMPT');
    var _decl = {
        data(){
            if (!1) _log('data0', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
            });

            return {
                _name: appName
            }
        },

        methods: {
            log: _log,
            __: __self,
            //call2: function(){},
        },

        mounted(){
            //_log('mounted-d', { this: this, appName });

            __root.saveComponent(appName, this);
        },
    }


    if (extend) {
        _decl = _extendDecl(_decl, extend, [_log])
    }

    return _decl

}