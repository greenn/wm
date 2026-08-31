<?
$Self = _rb::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
///$Self::req_js(1, 'drozd.vue-ext');
?>
_vue('<?=$vueName?>', function(_log, _cmd){
    //_log.set('loadItems', 0);

    return {
        _vue: {
            multiInstances: true,
            provide: {
                //drag: {},
                'drozd-pick': { store: true },
            },
            store: [],
            _store: {
                //onMounted: true, /pr: r/rb/vue/env-js/_vue/decl-store.js.inc:112
                nmIndex: 'name3'
            }
        },


        props: [
            'name3',
            'pick',
            'active',
            //'target',
            'openAlways', //open-always
        ],
        emits: ['in-focus'],

        data(){
            if(!1) this.clog('data/0', {
                name3: [this.name3, this.$attrs.name3, this.$props.name3],
                $props: this.$props,
                $attrs: this.$attrs,
                openAlways: this.openAlways,
            });
            var isAlwaysOpen = this.openAlways === '' || this.openAlways;
            return {
                isAlwaysOpen,
                isOpen: isAlwaysOpen,

                inFocus: false,
            }
        },

        methods: {
            toggleOpen(){
                this.isOpen = !this.isOpen;
            },
        },

        watch: {
            active(state){
                this.clog('active', { state, name3: this.name3 })
                if (state) {
                    this.pickChange();
                }
            },
            inFocus(state){
                this.$emit('in-focus', state);
            }
        },

        mounted() {
            this.clog('mounted');
        },

        computed:{
            hotkeysEnabled(){
                return this.$props.active && this.inFocus;
                //return this.active && this.inFocus;
            },
        },
    }
})