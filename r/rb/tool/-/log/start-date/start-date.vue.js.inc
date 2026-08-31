_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){

    var inputFormat = 'YYYY-MM-DDTHH:mm:ss';
    return {
        _vue: {},
        props: ['start-time'],
        emits: ['onChange'],
        data: function(){
            return {
                autoset: true,
                field: {
                    value: this.getFieldValue()
                }
            }
        },

        methods: {
            setDate: function(){
                if (this.hasDiscrepancy()) {
                    //case: при внутреннем (в этом компоненте) измении значении
                    this.$emit('onChange', this.getFieldTime());
                }
            },

            getFieldValue: function(unixTime){
                var time = moment.unix(unixTime || this.$props.startTime);
                return time.format(inputFormat)
            },

            getFieldTime: function(fieldValue){
                return moment(fieldValue || this.field.value, inputFormat).unix();
            },

            //есть расхождение
            hasDiscrepancy: function(){
                var selfVal = this.getFieldTime();
                var appVal = this.startTime;
                return selfVal !== appVal;
            },
        },

        watch: {

            field: {
                //immediate: true
                deep: true,
                handler: function(data){
                    if (this.autoset) this.setDate();
                }
            },

            startTime: function(){
                if (this.hasDiscrepancy()) {
                    //case: при внешнем измении значении
                    this.field.value = this.getFieldValue();
                }
            }
        },

    }
})