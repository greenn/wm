_vue('ui-custom', function(_log, _cmd){
    return {

        props: ['fieldValue'],
        emits: ['update:fieldValue'],
        data() {
            return {
                localFieldValue: this.fieldValue
            };
        },
        watch: {
            localFieldValue(newValue) {
                this.$emit('update:fieldValue', newValue);
            }
        }

    }
})