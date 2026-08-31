<?/*
    ug-provide
        { 'intervalRelValues': {
            intervalRelValues: {
                defType: 'date',
                propType: 'dateType'
                propInfo: 'info',
                propValue: 'value',
            },
            setRelValues: { from: 'from', to: 'to' }
        }},

*/?>
//_vue.providerDep['intervalRelValues'] = ['getCurrentDateTime'];

_vue.provider['__intervalRelValues'] = {

    data: function(){
        return {
            from: '',
            to: '',
        }
    },

    methods: {
        _intervalRelValues: function(cfg){
            cfg = _.merge({
                defType: 'date',
                propType: false, //'dateType',
                propInfo: 'info',
                propValue: 'value',
            }, cfg)

            return function intervalRelValues(){
                var dateType = cfg.propType && this[cfg.propType] || cfg.defType;
                var intervalInfoMap = this[cfg.propInfo];
                var intervalName = this[cfg.propValue];
                //this.log('intervalRelValues', { dateType, intervalInfoMap, intervalName })

                var to = _getCurrentDateTime(true, dateType);
                var intervalRules = intervalInfoMap[intervalName];
                var from = _getCurrentDateTime(intervalRules, dateType, true);

                return { to, from, intervalName }
            }
        },

        _setRelValues: function(cfg){
            cfg = _.merge({
                propFrom: 'from',
                propTo: 'to',
            }, cfg)

            return function setRelValues(){
                var interval = this.intervalRelValues();
                //this.log('setRelValues', { interval, cfg })
                //this.log('setRelValues', { interval, cfg, from: [cfg.propFrom, this[cfg.propFrom]], $data: this.$data })
                this[cfg.propFrom] = interval.from;
                this[cfg.propTo] = interval.to;
            }
        }

    },

    watch: {
        value(){
            this.setRelValues();
        }
    },
}

