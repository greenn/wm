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
                    vuex: _TtpMessagings,
                    apiBase: 'tpl_messagings',
                    rName: 'tpl_messagings', //rootName | rName | parName |
                    methods: {
                        //calcCoverage: true,
                        update: true,
                        create: true,
                        fetchForm: {
                            next: function(item){
                                //item.targets = _r(_TtpMessagings, 'prepareItemTargets', item.targets);
                                //_log('fetchForm/data', { item: _cc(item), targets: _cc(item.targets) });
                            }
                        },
                        reset: true
                    }
                } }
                //'applyRealParentMethod', 'getRealParent', 'applyParentMethod'
            ],
        },

        data(){
            //_r('app', 'iq', 'tpl_messagings');
            //_log('data');

            return {
                saved_fields: {},

                fields: {
                    uid: '', //update
                    title: '',
                    //targets: [],
                },

                busy: false, //крутилка поверх формы
                busyForm: false, //крутилка внизу у кнопок

                mode: 'create',

                validated: undefined, //dbg
            }
        },

        methods: {
            //link() @provide
            //linkBack() @provide
            //linkPar() @provide

            /*
            @provide crud-form
                update()
                create()
                fetchForm()

                updateSavedValue()
                isMode()
            */


            validate: function(){
                _log('validate');

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

                //oo kot/r/targets/target-form.v2.vue.js.inc:76


                var res = _.every(resList);
                this.validated = res;
                //_log('validate/res', { res, resList })
                return res;

            },
        },


        computed: {
            //hasChanges() @provide crud-form
        },

        mounted(){
            if (this.$route.name == 'tpl_messagings-edit') {
                this.mode = 'update';
                this.fetchForm(function(itemData) {
                    //_log('mounted/fetchForm/initData', { initData: _cc(self.fields), itemData })
                    //фетчим данные, и сохраняем текущее состояние
                    //self.updateSavedValue()
                });
            }
        },
    }
})