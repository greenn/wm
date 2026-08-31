<?
$Self = _rt::name('app-busy');
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
//admin-r-kmod
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            //provide: [],
            //store: [], //_store: {}
        },

        props: [],
        data(){
            return {
                busy: {
                    api: false,
                },
                data3: '',
                data4: '',
            }
        },

        methods: {

            addData3(){
                $form.data3 = this.data3;
            },
            addData4(){
                this.form.data4 = this.data4;
            },

        },
        computed: {
            isBusy(){
                var self = this;
                var busyData = this.busy;
                return function(prop) {
                    return prop ? busyData[prop] : _.some(busyData, Boolean);
                }
            },


            form: {
                get() {
                    return $form;
                },
                set(newValue) {
                    // Обновляем все свойства $cardsSearch
                    Object.assign($form, newValue);
                }
            }

        },

        mounted(){
            this._log('mounted');
        },
    }
})