<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();




?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        emits: ['assignData', 'onRemove'],
        props: ['fetchData'],

        data(){
            //_log('data');
            return {
                cfg: {
                    id: 0,
                    passes_min: 0,
                    'passes_min-fix': false,
                    from: _getCurrentDateTime({ week: -1 }, true),
                    'from-fix': true,
                    to: _getCurrentDateTime(true, true),
                    'to-fix': true,
                }
            }
        },



        methods: {
            onReady: function(){
                if (this.fetchData) { //case: update form ~ initData
                    this.fetchData();
                } else { //case: create form //#П1-4
                    this.$emit('assignData', this.cfg)
                }
            }
        },

        mounted(){
            //_log('mounted', { on_mount: this.on_mount })
            //this.regParent();

            this.onReady();
        },
    }
})