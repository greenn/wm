_vue.providerDep['target-tpl/onReady'] = [
    'target-tpl/fetchInitData',
];

_vue.provider['target-tpl/onReady'] = function(data){
    //_log('isReady');

    if (this.initData) {
        this.fetchInitData();
    }

    this.ready = true;
};