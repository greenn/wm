<?/*

-   -   -   -   https://thewebdev.info/2022/03/13/how-to-get-children-by-component-name-with-vue-js/
this.$root.$children.find((child) => {
  return child.$options.name === "name";
});

-   -   -   -

*/?>
var p_parent = {}
p_parent.nativeNames = [
    'BaseTransition',
    'KeepAlive',
];

p_parent.dbg = function(self){
    var $P1 = self.$parent;
    var $P2 = self.$parent.$parent;
    _log('[Provider]getParent', {

        1: { __file: $P1.$options.__file, name: $P1.$options.name, _componentTag: $P1.$options._componentTag, $refs: _clearObject($P1.$refs), $el: _clearObject($P1.$el) },
        2: { __file: $P2.$options.__file, name: $P2.$options.name, _componentTag: $P2.$options._componentTag, $refs: _clearObject($P2.$refs), $el: _clearObject($P2.$el) },

        //1: _clearObject($P1.$options),
        //2: _clearObject($P2.$options),

        //1: { $options: _clearObject($P1.$options), self: _clearObject($P1) },
        //2: { $options: _clearObject($P2.$options), self: _clearObject($P2) },
    })
}

//по имени
Provider.getParent = function(name, relative){
    var $parent, parentName, hasMatch, hasStrictName, hasRelativeName;
    var $resParent = false;
    var the_end = false;

    do {
        $parent = $parent ? $parent.$parent : this.$parent;
        the_end = !$parent;

        parentName = $parent._name;// || $parent.$options.name;
        hasStrictName = name === parentName;
        hasRelativeName = _.startsWith(parentName, name);
        hasMatch = relative ? hasRelativeName : hasStrictName;
        if (hasMatch) {
            $resParent = $parent
        }
    } while (!$resParent && !the_end);

    return $resParent;
}

ProviderDep.applyParentMethod = ['getParent'];
Provider.applyParentMethod = function(parentName, method/*, arg1, argN*/){
    var res = null;
    var $parent = this.getParent(parentName);
    //var $parent = Provider.getParent.call(this, parentName);
    if ($parent && $parent[method]) {
        var args = _.slice(arguments, 2);
        res = $parent[method].apply($parent, args);
    }
    return res;
}

Provider.getRealParent = function(){
    //p_parent.dbg(this)

    var $parent, parentName, vueName;
    var $realParent = false;
    var the_end = false;
    var _n = 0; //dbg
    do {
        _n++; //dbg
        $parent = $parent ? $parent.$parent : this.$parent;
        the_end = !$parent;

        parentName = $parent.$options.name;
        vueName = $parent._name; //01
        //_log('getRealParent', { parentName, _n })
        if (!parentName || !_.includes(p_parent.nativeNames, parentName)) {
            $realParent = $parent
        }
        ///_log({ the_end, parentName, $parent, $realParent, 'while': !$realParent && !the_end })
        //debugger;
        //_log('getRealParent|' + _n, { parentName, $parent: _clearClone($parent), $realParent: !!$realParent });
    } while (!$realParent && !the_end);

    return $realParent;
};

ProviderDep.applyRealParentMethod = ['getRealParent'];
//[nrs] applyRealParentMethod('regButton', this)
Provider.applyRealParentMethod = function(method/*, arg1, argN*/){
    var res = null;
    //var $parent = this.getRealParent();
    var $parent = Provider.getRealParent.call(this);
    if ($parent && $parent[method]) {
        var args = _.slice(arguments, 1);
        res = $parent[method].apply($parent, args);
    }
    return res;
}
