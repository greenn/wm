<?
$Self = _kot::self();
$n = $Self::nc();

js::wreq('external-click.jq');
?>

_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'getParent',
                'getRealParent',
                { 'linkRel': '<?=_kot::namedUrl('trg')?>' },
            ]
        },

        emits: [
            //'onModalOpen', //2)
            //'onDelete',
            //'onCopy',
        ],
        props: ['item'],

        data(){
            //_log('data', { item: this.item, prop_item: this.$props.item });
            var self = this;
            var item = this.item; //via props

            var defList = function(){
                var list = [];
                list.push({
                    icon: 'subject',
                    title: 'Полная информация',
                    click: function(){
                        self.linkRel(item.uid);
                    }
                })
                list.push({
                    name: 'preview',
                    icon: 'visibility',
                    title: 'Предпросмотр',
                    disabled: true,
                    click: function(){
                        self._log('Предпросмотр', { item })
                    }
                });

                list.push({
                    name: 'aproove',
                    icon: 'sync_lock', //verified_user
                    title: 'Поменять статус', //Согласовать / Отправить на согласование
                    //disabled: true,
                    hidden: item.aprooved,
                    //hidden: self.hideAproove,
                    click: function(btn){
                        //self._log('Согласовать', { item })
                        _r('targets', 'itemAproove_popup', item, {
                            busy: [self.getRealParent()], //показать крутилку на таблице
                            next: function(response){
                                //_log('Согласовать', { item, btn })
                                //btn.hidden = true;
                                //self.onAprooved(true);
                                self.open = false; //закрыть модальное(контекстное) окно
                            },
                        });
                    }
                });

                list.push({
                    name: 'reject',
                    icon: 'sync_lock', //thumb_down
                    title: 'Поменять статус', //Отклонить
                    //disabled: true,
                    hidden: !item.aprooved,
                    click: function(){
                        //self._log('Отклонить', { item })
                        _r('targets', 'itemReject_popup', item, {
                            busy: [self.getRealParent()], //показать крутилку на таблице
                            next: function(){
                                //self.onAprooved(false);
                                self.open = false; //закрыть модальное(контекстное) окно
                            },
                        });
                    }
                });

                list.push({
                    icon: 'content_copy',
                    title: 'Копировать',
                    click: function(){
                        _r('targets', 'itemCopy', item, {
                            next: function(response){
                                //1
                                //self.open = false; //закрыть модальное(контекстное) окно

                                //2
                                //_log('copy/response', { response });
                                self.linkRel(response.data['new-id']);
                            },
                            busy: [self.getRealParent()]
                        });
                    }
                });

                list.push({
                    icon: 'delete',
                    title: 'Удалить',
                    click: function(){

                        _r('targets', 'itemRemove_popup', item, {
                            busy: [self.getRealParent()]
                        });

                        /*_r('targets', 'itemRemove_popup', item, function(){
                            self.$emit('onDelete', item)
                        })*/
                    }
                })

                return list;
            }


            return {
                open: false,
                list: defList()
            }
        },

        methods: {
            getButton: function(name){
                return _.find(this.list, { name })
            },

            onAprooved: function(isAprooved){
                var btnAprooved = this.getButton('aproove');
                var btnReject = this.getButton('reject');
                btnAprooved.hidden = isAprooved;
                btnReject.hidden = !isAprooved;
                //_log('onAproovedChange', { isAprooved, btnReject, btnAprooved })
            },


            fetchData: function(){
                _log('fetchData')
            },

            toggle: function(){
                var reverseValue = !this.open;
                this.open = reverseValue;

                if (this.open) {
                    //1) this._r('app', 'overlay', true);
                    //2) this.$emit('onModalOpen')
                    //3) Bus.emit('closeOthersModal', this.item.uid);
                }
            },

        },

        computed: {
            //hideReject() { return !this.item.aprooved },
            //hideAproove() { return !!this.item.aprooved },
        },

        watch: {
            'item.aprooved': {
                handler(aproovedState) {
                    this.onAprooved(aproovedState);
                },
                immediate: true <?//Запускать обработчик сразу при монтировании компонента?>
            }
        },

        mounted(){
            var self = this;
            /*3)
            Bus.on('closeOthersModal', function(uid){
                //console.log('onBus/closeOthersModal', [self.item.uid, uid]);
                if (self.item.uid !== uid) {
                    if (self.open) {
                        self.open = false;
                    }
                }
            });
            */

            //4)
            var $modal = $(this.$refs.modal)
            //this._log('mounted', { uid: self.item.uid, modal$ref: this.$refs.modal, is$modal: $modal.length })
            $modal.externalClick(function(){
                //self._log('externalClick/state', { uid: self.item.uid, isOpen: self.open });
                return self.open && !_r('popup', 'visible');
            }, function(){
                self.open = false;
            })

        },
    }
})