<?
$Self = _kmod::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [
                //{ 'linkRel': '<?=kot('hp', 'namedUrl', 'guzzler')?>' }
            ],

            store: [
                'textarea',
                'prm',
                'opt',
                'set',
            ],
            _store: {
                //reset: ['opt']
                //reset: ['set']
                //reset: ['opt', 'set']
                //reset: ['prm']
            }
        },

        data(){
            //_log('data');

            var self = this;
            return {
                busy: {},
                textarea: '',
                set: {
                    salt: { title: 'соль (key-data)', value: '' },
                    cutlery: { title: 'приборы (handler cb)', value: '', select: [], lock: true },
                    dish: { title: 'блюдо (handler)', value: 'json', select: [] },
                    plate: { title: 'тарела (file / target)', value: '', select: [],
                        cmd: [
                            { text: 'oo',
                                click: function(){
                                    _log('oo', { this: this, args: arguments })
                                },
                                disabled: function(){
                                    return !self.value || !_.includes(self.select, self.value)
                                }
                            }
                        ]
                    },

                    /*cb: { value: '', values: {
                        r: { text: '', placeholder: true },
                        tpl: { text: '', placeholder: true },
                    } },*/

                },
                prm: [ //дополнительные параметры к сохранению
                    { name: '', value: '', use: true }
                ],
                opt: {
                    'json-save': false,
                    'json-filter-comment': true,
                    'json-merge-data': true,
                    'json-backup-data': false,
                    'json-try-fix': true,
                },
                ingredients: [],
                seasoning: [],
            }
        },

        methods: {
            updateSelect(name){
                var self = this;
                self.busy[name] = true;
                ApiKMod.get('guzzler/get-select', { name }, function(responseData){
                    //self?.set[name]?.select = responseData?.options;
                    //_log('get-select/api', { responseData })
                    self.set[name].select = responseData.options || [];
                    self.busy[name] = false;
                })
            },

            onInput(){
                //_log('onInput');
            },

            prmAdd(){
                this.prm.push({ name: '', value: '', use: true })
            },
            prmDeleteLast(){
                this.prm.pop();
            },

            eat(){
                var self = this;
                //_log('eat');
                self.busy.eat = true;

                var prmList = _.transform(this.prm, function(res, data, key){
                    var name = data.name;
                    var value = data.value;
                    if (!name && value) name = key; //mp
                    if (name && data.use) {
                        res[name] = value
                    }
                }, {});

                var optList = _.transform(this.opt, function(res, value, name){
                    res[name] = value
                }, {});

                var setList = _.transform(this.set, function(res, item, name){
                    res[name] = item.value
                }, {});

                //_log('eat0', { prmList, optList, setList });
                ApiKMod.post('guzzler/eat', {
                    food: self.textarea,
                    ingredients: setList,
                    seasoning: optList,
                    spice: prmList,
                }, function(response){
                    //_log('eat/result', { response })
                    self.busy.eat = false;
                })

            },


        },

        mounted(){
            //_log('mounted')

            var self = this;
            _.each(this.set, function(item, name){
                if (item.select) self.updateSelect(name);
            })

        },
    }
})