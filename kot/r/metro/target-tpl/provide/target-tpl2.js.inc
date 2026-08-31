<?/*
    ug
        kot/r/target-tpl/passes/station-freq-tpl2.vue.js.inc
*/?>
_vue.provider['__target-tpl2'] = {

    //provideOpt: {},

    data: function(){
        return {
            coverage: false,
            busyCoverage: false,
        }
    },

    methods: {
        calcCoverage(){
            //this.log('calcCoverage@tt2', { cfg: this.cfg });
            var self = this;

            _r('targets', 'calcCoverage_aggregate', [this.cfg], {
                id: 0,
                busy: [this, 'busyCoverage'],
                next: function(coverageValue){
                    self.coverage = coverageValue;
                }
            })
        }
    },

    mounted(){
        //this.log('mounted|@tt2', { data: _cc(this.cfg) })
        this.calcCoverage()
    },

}