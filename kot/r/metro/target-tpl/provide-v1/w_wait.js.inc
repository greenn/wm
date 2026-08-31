_vue.providerDep['target-tpl/w:wait'] = [
    'target-tpl/onReady',
    'target-tpl/_w:cfg',
];

_vue.provider['target-tpl/w:wait'] = {
    deep: true,
    handler: function(val) {
        var ready = _.every(this.wait); //проверяем каждое ли значение true
        //_log('w:wait', { ready, val: _clone(val) })
        if (ready) this.onReady();
    },
};