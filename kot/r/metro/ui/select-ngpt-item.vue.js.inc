<?
$Self = _kot::self()
?>
_vue('select-ngpt-item', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                ///'ui/field/validate',
                    //по-хорошему здесь нужен 'target-tpl' /  iq/config/.dev/man target-tpl
            ],
        },

        props: [
            'label',
            'passes', 'type', 'id',
            'typeOptions', 'optionsData',
            'addButton', 'addButtonDisabled',
        ],
        emits: [
            'update:id',
            'update:type',
            'update:passes',

            'onAdd',
            'onRemove',
            'onBusy',
            'onReady',
        ],

        data: function(){
            return {
                busy: false,
                selfOptions: [],
                //station: '',

            }
        },


        methods: {

            setFocus: function(){ _log('setFocus') } //q0
        },

        computed: {

            options: function(){
                var type = this.type;
                var optionsData = this.optionsData;
                var options = type && optionsData && optionsData[type];
                //_log('c:options', { type, optionsData: _cc(optionsData), options: _cc(options), size: _.size(options) });
                return _.size(options) ? options : [{ value: '', text: 'нужен тип' }]
            }
        },


        mounted(){},
    }
})