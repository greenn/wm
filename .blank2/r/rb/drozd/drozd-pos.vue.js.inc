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
                'drozd-frame': { store: true },
            },
            store: [
                //@drag: drag
                //@drozd-frame: isOpen; bgOpt; hideOpt;
            ],
            _store: {}
        },


        props: [
            'target',
        ],

        emits: [
            //@drozd-frame: open-state
            'pos'
        ],

        data(){
            return {
                //@drozd-frame: hideOpt; bgOpt; isOpen; inFocus;
                pos: {
                    x: 0,
                    y: 0,
                    ds: false,
                    ds_x: 0,
                    ds_y: 0,
                    step: 1,
                    r: false,
                    r_disabled: false,
                    z: 100,
                    og_pos: undefined,
                    og_z: undefined,
                }
            }
        },

        methods: {
            //@drozd-frame: toggleOpen

            moveTargetStep(left, top){

                this.pos.x += left * this.pos.step;
                this.pos.y += top * this.pos.step;

                //this.applyPos()
            },

            moveReset(){
                this.pos.x = 0;
                this.pos.y = 0;
                if (!this.pos.r_disabled) {
                    this.pos.r = false;
                    this.pos.z = this.pos.og_z;
                }
            },

            applyPos(){
                if (this.target) {
                    var node = this.target();
                    this.clog('moveTargetStep/target', { node });
                    node.style.transform = `translate(${this.pos.x}px, ${this.pos.y}px)`;

                    if (!this.pos.r_disabled) {
                        node.style.position = this.pos.r ? 'relative' : this.pos.og_pos;
                    }

                    if (this.pos.r) {
                        node.style.zIndex = this.pos.z;
                    }

                }

                this.$emit('pos', this.pos)
            },

            bindHotkeysExtra(event){
                //if (this.hotkeysEnabled === false) return;
                if (!this.inFocus) return;
                this.clog('bindHotkeysExtra', { key: event.key });
                switch(event.key) {
                    case 'ArrowUp': case '8':
                        this.moveTargetStep(0, -1);
                        break;
                    case 'ArrowDown': case '2':
                        this.moveTargetStep(0, 1);
                        break;
                    case 'ArrowLeft': case '4':
                        this.moveTargetStep(-1, 0);
                        break;
                    case 'ArrowRight': case '6':
                        this.moveTargetStep(1, 0);
                        break;
                    case 'Home': case '7': //↖️|7
                        this.moveTargetStep(-1, -1);
                        break;
                    case 'PageUp': case '9': //↗️|9
                        this.moveTargetStep(1, -1);
                        break;
                    case 'End': case '1': //↙️|1
                        this.moveTargetStep(-1, 1);
                        break;
                    case 'Control':
                        var step = this.pos.step + 5;
                        this.pos.step = step;
                        break;
                    case 'Shift': case '3': //↘️|3
                        var step = this.pos.step - 5;
                        if (step < 1) step = 1;
                        this.pos.step = step;
                        break;
                }
            },

            dragTarget(e){
                this.pos.ds = true;
                this.pos.ds_x = e.clientX - this.pos.x;
                this.pos.ds_y = e.clientY - this.pos.y;

                document.addEventListener('mousemove', this.dragTargetMove)
                document.addEventListener('mouseup', this.dragTargetStop)
            },
            dragTargetStop(){
                this.pos.ds = false;
                document.removeEventListener('mousemove', this.dragTargetMove)
                document.removeEventListener('mouseup', this.dragTargetStop)
            },
            dragTargetMove(e){
                if (0) this.clog('dragTargetMove', {
                  pos: [this.pos.x, this.pos.y],
                  e: [e.clientX, e.clientY],
                  ds: [this.pos.ds_x, this.pos.ds_y],
                })
                this.pos.x = e.clientX - this.pos.ds_x
                this.pos.y = e.clientY - this.pos.ds_y
            },


        },

        watch: {
            //@drozd-frame: isOpen
            pos: {
                deep: true,
                handler(){
                    this.applyPos()
                },
            }
        },

        computed: {
            //@drozd-frame: titleStyle, bgStyle

        },

        mounted() {
            if (this.target) {
                var node = this.target();

                if (!this.pos.og_pos) {
                    var og_pos = node.style.position;
                    if (og_pos === 'relative' || og_pos === 'absolute' || og_pos === 'fixed') {
                        this.pos.r = true;
                        this.pos.r_disabled = true;
                    }

                    this.pos.og_pos = og_pos;
                    this.pos.og_z = node.style.zIndex;
                    this.pos.z = this.pos.og_z || 0;

                }
            }
            window.addEventListener('keydown', this.bindHotkeysExtra);
        }
    }
})