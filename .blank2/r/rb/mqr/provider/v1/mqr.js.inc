//Provider.aaaa = function(){ alert('4') }

_vue.providerDep['mqr'] = [
    'initMQAutoResize',
	'MQAutoResize',

	//'isNumeric',
	'splitValueAndUnit',
	'convertStringToTypedValue',
]

/*_vue.provider['__mqr2'] = function(__cfg){
    return {
        methods: {
            initMQAutoResize(){},
            MQAutoResize(){},
		}
	}
}*/

<? include_once 'mqr-initMQAutoResize.js.inc'; ?>

<? include_once 'mqr-MQAutoResize.js.inc'; ?>