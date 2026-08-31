//const VOutput = {
_Page.component('v-output', {
    template: '#v-output',

    data(){
        return {
            value: '-'
        }
    },

    computed: {
        responseContent() {
            var value = this.value;
            return value;
        }
    },

//}
})