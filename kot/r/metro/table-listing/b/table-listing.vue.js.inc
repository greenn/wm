<?
$Self = _kot::self();
$n = $Self::nc();
?>

_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){


    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                //'link', //'linkBack',
                { 'linkRel': '<?=_kot::namedUrl('trg')?>' },
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        //emits: ['onDelete'],
        props: ['items'],

        data(){
            //_log('data');

            return {
                //head: th_list,
                //items: [],
                modals: [],
                tr_selected: undefined,
                busy: false,
                forecastBusy: false,
            }
        },

        methods: {
            /*closeOthersModal: function(exceptUid){
                _log('closeOthersModal', { uid: exceptUid })
                Bus.emit('closeOthersModal', exceptUid);
            }*/

                listRemove: function(item){
                    var self = this;
                    const index = _.findIndex(self.items, { uid: item.uid });
                    //_log('listRemove', { list: self.items, item, idx1: index, idx2: _.findIndex(self.items, item) })
                    self.busy = true;
                    _delay(200, function(){
                        if (index !== -1) {
                            self.items.splice(index, 1);
                            self.busy = false;
                        }
                    })
                },

                linkAdd: function(item){
                    _log('linkAdd', { item });
                    var self = this;
                    self.busy = true;
                    _delay(150, function(){
                        self.items.push(item)
                        self.busy = false;
                    })
                }
        },
        computed: {
            totalItems: function(){
                return this.items.length
            }
        },

        mounted(){
            ///_log('mounted', { _this: _clearObject(this), $data: this.$data, _$data: _clearObject(this.$data ) });
            ///console.dir(this);

                /*var $parent = this.getRealParent();
                if ($parent && $parent.regButton) {
                    $parent.regButton(this);
                }*/

                //_log('mounted', { $parent: this.$parent });
                //this.applyRealParentMethod('regButton', this);


            return;
            Api.assignArray({
                api: 'targets/list',
                this: this, resProp: 'items',
                busy: true,
                //busy: [this, 'busy']
                //dbg: true
            });

            //_log('mounted', { refs: this.$refs, modals:  this.modals })

        },
    }
})