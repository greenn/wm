

_vue.provider['__drozd-frame'] = function(__cfg){
    var vueCfg = {
        provide: []
    };

    if (__cfg.store) vueCfg.store = [
        'isOpen', 'bgOpt', 'hideOpt'
    ];

    return {
        _vue: vueCfg,

        props: [],
        emits: ['open-state'],

        data(){
            //this.clog('data/0', this);
            return {
                hideOpt: {
                    hide: false
                },
                bgOpt: {
                    bg: false,
                },
                isOpen: false,
                inFocus: false,
            }
        },

        methods: {
            toggleOpen(){
                this.isOpen = !this.isOpen;
            },


        },

        watch: {
            isOpen(state){
                this.$emit('open-state', state);
            },
        },

        computed:{
            titleStyle(){
				<?//:style="{ '--bc': inFocus ? 'deepskyblue' : isOpen ? 'grey' : '', color: 'var(--bc)' }?>
                var css = {
                    '--bc': '',
                    color: 'var(--bc)'
                }
                if (this.inFocus) {
                    css['--bc'] = 'deepskyblue';
                } else if (this.isOpen) {
                    css['--bc'] = 'grey';
                }
                return css;
            },

            bgStyle(){
                var css = {};
                ///this.clog('c:bgStyle', { bgOpt: this.bgOpt, inFocus: this.inFocus, isOpen: this.isOpen })
                if (!this.hideOpt.hide) {
                    if (this.bgOpt.bg) {
                        css['background-color'] = 'white';
                    } else if (this.inFocus) {
                        css['background-color'] = 'rgb(127 255 212 / 62%)';
                    } else if (this.isOpen) {
                        css['background-color'] = 'rgb(215 226 90 / 16%)';
                    }
                }
                return css;
            }
        },

        mounted() {

            if(0) this.clog('mounted', {
                'pickSelected': this.pickSelected,
                'pickOpt': this.pickOpt,
                'pickLevelUsage': this.pickLevelUsage,
                'pickLevelUsageInited': this.pickLevelUsageInited,
            }, {})

            if (this.pickSelected) { //ak immediate: ручной запуск w:pickSelected в mounted,
                // т.к. pr immediate: true запускается до mounted
                // a handler появляется из-за store r/rb/vue/env-js/_vue/decl-store.js.inc:90
                //this.$options.watch.pickSelected.handler.call(this, this.pickSelected);

                this.pickChange();
            }

            //this.clog('@drozd-pick/')
            window.addEventListener('keydown', this.bindHotkeys)
        }
    }
}