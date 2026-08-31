_vue.providerDep['target-tpl/fetchInitData'] = [
    'target-tpl/fetchData',
];

_vue.provider['target-tpl/fetchInitData'] = function(data){
    //if (!this.initData) return;

    //step: fetchInitData
    if (typeof this.initData === 'function') {
        this.initData.call(this)
    } else {
        this.fetchData(this.initData);
    }
};