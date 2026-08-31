<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'regField', 'regButton',
                'link', 'linkBack', 'linkPar',
                { 'crud-form': {
                    vuex: _Messagings,
                    apiBase: 'messagings',
                    rName: 'messagings', //rootName | rName | parName |
                    methods: {
                        //calcCoverage: true,
                        update: true,
                        create: true,
                        fetchForm: {
                            next: function(item){
                                //item.targets = _r(_Messagings, 'prepareItemTargets', item.targets);
                                //_log('fetchForm/data', { item: _cc(item), targets: _cc(item.targets) });
                            }
                        },
                        //reset: true
                    }
                } }
                //'applyRealParentMethod', 'getRealParent', 'applyParentMethod'
            ],
        },

        data(){
            //_r('app', 'iq', 'messagings');
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
                //busyCoverage: false,
                mode: 'create',

                validated: undefined, //dbg
            }
        },

        methods: {



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