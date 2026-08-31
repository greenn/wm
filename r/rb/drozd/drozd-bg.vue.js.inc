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
                drag: { store: true },
                'drozd-pick': { store: true },
                //@drozd-pick: utils-range
                'drozd-frame': { store: true },
            },
            store: [
                //@drozd-pick: pickOpt; pickSelected; pickLevels; pickLevelUsage; pickLevelUsageInited;
                //@drag: drag
                //@drozd-frame: isOpen; bgOpt; hideOpt;
            ],
            _store: {
                ///reset: ['bgOpt'],
                ///_nmIndex: 'name1'
            }
        },


        props: [
            //@drozd-pick: pick
            'target',
            'relFocus'
        ],

        emits: [
            //@drozd-pick: pick
            //@drozd-frame: open-state
        ],

        data(){
            //this.clog('data/0', this);

            return {
                //@drozd-pick: pickOpt; pickSelected; pickHovered;
                    //pickLevels; pickLevelUsage; pickLevelUsageInited;

                //@drozd-frame: hideOpt; bgOpt; isOpen; inFocus;
            }
        },

        methods: {
            //@drozd-pick: pickChange; bindHotkeys;
                //getNextPickKey; getNextPickKeyByLevel;
                //pickMaxLevelCount; setPickLevel;
                //@range: range; makeRange
            //@drozd-frame: toggleOpen


            bindHotkeysExtra(event){
                //if (this.hotkeysEnabled === false) return;
                if (!this.inFocus) return;
                //this.clog('bindHotkeysExtra', { key: event.key });
                switch(event.key) {
                    case 'x':
                        this.hideOpt.hide = !this.hideOpt.hide;
                        break;
                }
            }
        },

        watch: {
            //@drozd-pick: pickSelected, pick, pickMaxLevel
            //@drozd-frame: isOpen

            //dd
                /*relFocus(state){
                    this.hotkeysEnabled = !state && this.inFocus;
                },
                inFocus(state){
                    this.hotkeysEnabled = !this.relFocus && state;
                },*/

        },

        computed: {
            //@drozd-pick: pickKeys, pickMaxLevel
            //@drozd-frame: titleStyle, bgStyle
            hotkeysEnabled(){
                return !this.relFocus && this.inFocus;
            },



        },

        mounted() {
            //@drozd-pick

            window.addEventListener('keydown', this.bindHotkeysExtra)
        }
    }
})