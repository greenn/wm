
var _saveDecl = function(name, decl){
    _decl[name] = _.cloneDeep(decl);
    _log('saveDecl', { name, decl: _decl[name] });
}

var _extendDecl = function(decl, extend, extend_args){
    if (_.isFunction(extend)) {
        extend = extend.apply(__root, _.castArray(extend_args || []));
    }

    //dbg
    //var cloneDecl =  _clearClone(decl);
    //var cloneExtend = _clearClone(extend);

    decl = VueDecl.extend(decl, extend);

    //dbg
    //_log('_extendDecl', { decl: cloneDecl, extend: cloneExtend, result: _clearClone(decl) });

    return decl;
}




//getDeclComponent | getComponentDecl
__root.getDecl = function(cmptName, clone){

    return !clone ? _decl[cmptName] : __root.cloneDecl(cmptName, clone)
}

//ak getDecl / copyDecl / cloneDecl
__root.cloneDecl = function(cmptName, extend){
    var decl = _decl[cmptName]
    decl = _.cloneDeep(decl);
ё
    if (extend && (extend !== true)) {
        decl = _extendDecl(decl, extend)
    }

    return decl;
}