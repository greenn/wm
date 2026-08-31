<?/*
    ug
        { 'crud': {
            vuex: _Targets,
            apiBase: 'targets',

            methods: {
                remove: true,
                copy: true,
                aproove: true,  
                reject: true,
                coverage: true,
                create: true,
                update: true
            }
        } }

*/?>

<? $js; ?>
//_vue.providerDep['crud'] = [''];

_vue.provider['__crud'] = function(__cfg){

    var _extension = {
        template: ' ',
        methods: {},
    }

    var _apiBase = __cfg.apiBase;
    var _Vuex = __cfg.vuex;

    var _methods = __cfg.methods;
    _methods = _mapCfg(_methods, { cfgArg: __cfg });

    //_log('provide/crud', { __cfg, _methods, _apiBase, _Vuex })

    _.each(_methods, function(_cfg, name){
        switch (name) {
            case 'create': {
                //_extension.methods.itemCreate = _itemCreate(_cfg)
		        <? include $js['provide/crud/create'] //itemCreate() ?>
            } break;
            case 'update': {
		        <? include $js['provide/crud/update'] //itemUpdate() ?>
            } break;
            case 'remove': {
	            <? include $js['provide/crud/remove']; //itemRemove_popup(), itemRemove() ?>
            } break;
            case 'copy': {
	            <? include $js['provide/crud/copy'] //itemCopy_popup(), itemCopy() ?>
            } break;
            case 'aproove': {
	            <? include $js['provide/crud/aproove'] //itemAproove_popup(), itemAproove() ?>
            } break;
            case 'reject': {
	            <? include $js['provide/crud/reject'] //itemReject_popup(), itemReject() ?>
            } break;
            case 'coverage': {
	            <? include $js['provide/crud/coverage'] //calcCoverage(), calcCoverage_batch() ?>
            } break;

        }
    })


    return _extension;
}