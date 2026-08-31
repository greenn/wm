//Provider.aaaa = function(){ alert('4') }

_vue.providerDep['mqr'] = [
    'initMQAutoResize',
	'MQAutoResize',

	'isNumeric',
	'splitValueAndUnit',
	'convertStringToTypedValue',
]

_vue.provider['__mqr'] = function(__cfg){
    //_log('__mqr', { __cfg })

    var og_cfgDbg = __cfg.dbg;
    if (typeof og_cfgDbg !== 'function') {
        __cfg.dbg =  function() { return og_cfgDbg }
    }

    var mqrTopArgs = arguments

    var __mqr = {
        data: function(){
            return {
                mqList: [],
            }
        },

        methods: {},
        mounted: function(){

            if (__cfg.init) this.initMQAutoResize();

        },
    };

	<? include_once 'initMQAutoResize.js.inc'; ?>;
	<? include_once 'MQAutoResize.js.inc'; ?>;

    return __mqr;
}



