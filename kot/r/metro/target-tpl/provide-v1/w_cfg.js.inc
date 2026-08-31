_vue.providerDep['target-tpl/_w:cfg'] = [
    'target-tpl/w:wait',
];

_vue.provider['target-tpl/_w:cfg'] = function(){
    return {
        deep: true,
        handler: function(val){
            //_log('w:cfg', { cfg: this.cfg, _cfg: _cc(this.cfg), ready: this.ready });
            if (this.ready) {
                //_log('onChange', { data: this.cfg });
                this.$emit('onChange', this.cfg)
            }
        }
    }
}