_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        _vue: {},

        props: ['text'],

        emits: ['press'],

        data: function(){
            return {
                selected: false
            }
        },

        methods: {
            click: function(){
                _log('click');
                this.selected = !this.selected;
                this.$emit('press', this.selected)
            },

        },
        watch: {},
        mounted: function() {
            /*_log('item-data', {
                '$attrs.text': this.$attrs.text,
                selected: this.selected,
                text: this.text,
            })*/
            _log('mounted', {
                $props: this.$props
            })
        }
    }
})