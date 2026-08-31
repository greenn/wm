<?/*ug*/ if (0) { ?>
@provide = { 'crud-modal': {
    rName: 'targets',
    methods: [
        'info',
        'preview',
        'aproove',
        'reject',
        'copy',
        'delete',
    ]
} }
<? } ?>

<?
    $js;
    js::wreq('external-click.jq');
?>
_vue.providerDep['crud-modal'] = ['getRealParent'];

_vue.provider['__crud-modal'] = function(__cfg){

    var _rName = __cfg.rName;

    var _methods = __cfg.methods;
    //_methods = _mapCfg(_methods, { cfgArg: __cfg });
    _methods = _mapCfg(_methods);


    var _extension = {
        data(){
            //_log('data', { item: this.item, prop_item: this.$props.item });
            var self = this;
            var item = this.item; //via props

            var _src = {

                info: {
                    icon: 'subject',
                    title: 'Полная информация',
                    click: function(){
                        self.linkRel(item.uid);
                    }
                },

                preview: {
                    name: 'preview',
                    icon: 'visibility',
                    title: 'Предпросмотр',
                    disabled: true,
                    click: function(){
                        self._log('Предпросмотр', { item })
                    }
                },

                aproove: {
                    name: 'aproove',
                    icon: 'sync_lock', //verified_user
                    title: 'Поменять статус', //Согласовать / Отправить на согласование
                    //disabled: true,
                    hidden: item.aprooved,
                    //hidden: self.hideAproove,
                    click: function(btn){
                        //self._log('Согласовать', { item })
                        _r(_rName, 'itemAproove_popup', item, {
                            busy: [self.getRealParent()], //показать крутилку на таблице
                            next: function(response){
                                //_log('Согласовать', { item, btn })
                                //btn.hidden = true;
                                //self.onAprooved(true);
                                self.open = false; //закрыть модальное(контекстное) окно
                            },
                        });
                    }
                },

                reject: {
                    name: 'reject',
                    icon: 'sync_lock', //thumb_down
                    title: 'Поменять статус', //Отклонить
                    //disabled: true,
                    hidden: !item.aprooved,
                    click: function(){
                        //self._log('Отклонить', { item })
                        _r(_rName, 'itemReject_popup', item, {
                            busy: [self.getRealParent()], //показать крутилку на таблице
                            next: function(){
                                //self.onAprooved(false);
                                self.open = false; //закрыть модальное(контекстное) окно
                            },
                        });
                    }
                },

                copy: {
                    icon: 'content_copy',
                    title: 'Копировать',
                    click: function(){
                        _r(_rName, 'itemCopy', item, {
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
                },

                'delete': {
                    icon: 'delete',
                    title: 'Удалить',
                    click: function(){

                        _r(_rName, 'itemRemove_popup', item, {
                            busy: [self.getRealParent()]
                        });

                        /*_r(_rName, 'itemRemove_popup', item, function(){
                            self.$emit('onDelete', item)
                        })*/
                    }
                },

            }

            var list = [];
            _.each(_methods, function(cfg, name){
                list.push(_src[name])
            })

            return {
                open: false,
                list: list
            }
        },

        methods: {
            getButton: function(name){
                return _.find(this.list, { name })
            },

            toggle: function(){
                var reverseValue = !this.open;
                this.open = reverseValue;

                /*if (this.open) {
                    //1) this._r('app', 'overlay', true);
                    //2) this.$emit('onModalOpen')
                    //3) Bus.emit('closeOthersModal', this.item.uid);
                }*/
            },
        },

        watch: {},

        mounted(){
            var self = this;

            var $modal = $(this.$refs.modal)
            //this._log('mounted', { uid: self.item.uid, modal$ref: this.$refs.modal, is$modal: $modal.length })
            $modal.externalClick(function(){
                //self._log('externalClick/state', { uid: self.item.uid, isOpen: self.open });
                return self.open && !_r('popup', 'visible');
            }, function(){
                self.open = false;
            })
        }
    }


    if (_methods.aproove || _methods.reject) {
        _extension.methods.onAprooved = function(isAprooved){
            var btnAprooved = this.getButton('aproove');
            var btnReject = this.getButton('reject');
            btnAprooved.hidden = isAprooved;
            btnReject.hidden = !isAprooved;
            //_log('onAproovedChange', { isAprooved, btnReject, btnAprooved })
        }
    }

    if (_methods.aproove) {
        _extension.watch['item.aprooved'] = {
            handler(aproovedState) {
                this.onAprooved(aproovedState);
            },
            immediate: true <?//Запускать обработчик сразу при монтировании компонента?>
        }
    }

    //_log('@provide/crud-item', { __cfg, _extension })


    return _extension;
}