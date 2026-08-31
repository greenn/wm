_vue('s-toggle', function(_log){
    return {
        data: function(){
            return {
                status: this.$attrs.state
            }
        },
        watch: {
            status: function(isOpen){
                if (isOpen) {
                    this.$emit('open')
                } else {
                    this.$emit('close')
                }
            }
        },

        mounted: function() {}
    }
})