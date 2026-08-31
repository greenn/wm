<?
$Self = _kot::self();

?>
_vue('target-form', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'regField', 'regButton',
                'link', 'linkBack', 'linkPar',
                //'applyRealParentMethod', 'getRealParent', 'applyParentMethod'
            ],
        },

        data(){
            _r('app', 'iq', 'targets');

            //_log('data');
            return {
                saved_fields: {},
                fields: {
                    uid: '', //update
                    title: '',
                    targets: [],
                },

                busy: false, //крутилка поверх формы
                busyForm: false, //крутилка внизу у кнопок
                busyCoverage: false,
                mode: 'create',

                validated: undefined, //dbg
            }
        },

        methods: {

            calcCoverage: function(then){
                var self = this;
                //_log('calcCoverage', { fields: _cc(this.fields) });

                this.$refs.constructor.calcCoverage();

                _r('targets', 'calcCoverage_aggregate', this.fields.targets, {
                    id: this.fields.uid,
                    busy: [this, 'busyCoverage'],
                    next: function(coverageValue){
                        if (self.isMode('create')) {}
                        self.fields.forecast = coverageValue;
                        //then && setTimeout(then, 0);

                        then && then();
                    }
                })
            },

            update: function(){
                var self = this;
                _r('targets', 'itemUpdate', {
                    id: this.fields.uid,
                    fields: this.fields,
                }, {
                    busy: [this, 'busyForm'],
                    next: function(){
                        self.linkPar();
                    }
                })
            },

            create: function(){
                var self = this;

                _r('targets', 'itemCreate', this.fields, {
                    busy: [this, 'busyForm'],
                    next: function(){
                        self.linkPar();
                    }
                })
            },

            //выставляем данные для компонента
            fetchForm: function(next){
                var self = this;
                var id = this.$route.params.id;
                //_log('fetchForm', { id, route: this.$route });

                _Targets.dispatch('itemGet', {
                    uid: this.$route.params.id,
                    busy: [this, 'busy'],
                    next: function(item){
                        if (item) {
                            item.targets = _r('targets', 'prepareItemTargets', item.targets);
                            _log('fetchForm/data', { item: _cc(item), targets: _cc(item.targets) });

                            self.fields = item;

                            next && next(item)
                        }
                    },
                });

            },

            reset: function(){},
            updateSavedValue: function(){
                var prev_savedFields = _clone(this.saved_fields);
                this.saved_fields = _clone(this.fields);
                ///_log('updateSavedValue', { prev_savedFields, savedFields: this.saved_fields, wasChanges: !_.isEqual(this.saved_fields, prev_savedFields) });
                //_log('updateSavedValue/hasChanges', { hasChanges: this.hasChanges });
            },

            isMode(name){
                return this.mode === name;
            },

            validate: function(){
                //this.busyForm = true;
                var resList = [];
                var itemRes;
                var setFocus = true;
                //if (!this.fields.title || 1) {
                    itemRes = this.$refs.title.validate({
                        validateOnChange: true,
                        stopValidateOnSuccess: true,
                        isValid: function(value){
                            //return value.length > 3; //dbg
                            return value !== '';
                        },
                    }, setFocus);

                    //_log('validate/1', { res: itemRes });
                    if (!itemRes && setFocus) setFocus = false; //фокус уже проставился
                    resList.push(itemRes);
                    //res *= itemRes;
                //}

                itemRes = this.validateTargets();

                //_log('validate/2', { res: itemRes });
                if (!itemRes && setFocus) setFocus = false; //фокус уже проставился
                resList.push(itemRes);
                //res *= itemRes;


                //this.busyForm = false;
                var res = _.every(resList);
                this.validated = res;
                _log('validate', { res, resList })
                return res;
            },

            validateTargets: function(){
                return this.$refs.constructor.validate();
            }

        },


        computed: {
            hasTargets(){
                return this.fields.targets && this.fields.targets.length
            },
            hasChanges(){
                var isEqual = _.isEqual(this.saved_fields, this.fields);
                //_log('c:hasChanges', { isEqual, fields: _cc(this.fields), saved_fields: _cc(this.saved_fields) })
                return !isEqual;
            },
        },

        mounted(){
            var self = this;
            //_log('mounted', { routeName: this.$route.name, route: this.$route, _name: this._name, __: this.__ })
            _rr.saveComponent('target-form', this); //#П0-

            if (this.$route.name == 'target-edit') {
                this.mode = 'update';
                this.fetchForm(function(itemData) {
                    //_log('!!hasData'); return;
                    //_log('mounted/fetchForm/initData', { initData: _cc(self.fields), itemData })
                    //фетчим данные, и сохраняем текущее состояние
                    self.$refs.constructor.initData(self.fields.targets, self.updateSavedValue);

                    self.calcCoverage();
                });
            }
        },
    }
})