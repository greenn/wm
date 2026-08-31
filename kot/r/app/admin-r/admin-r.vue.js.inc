<?
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
//admin-r-kmod
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [
                //{ 'linkRel': '<?=kot('hp', 'namedUrl', $vueName)?>' }

                { 'set-fields': {
                    'Api': ApiKot,
                    'api-base': 'admin-r',
                    'api-select': 'get-select',

                } },

            ],

            store: [
                //'textarea',
                //'prm',
                //'opt',
                'set',
            ],
            _store: {
                //_nmIndex: 'name1'

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

                set: {
                    'kmod': { title: 'kmod', value: '', select: [] },
                },
                opt: {
                    'opt-1': false,
                    'opt-2': false,
                },

            }
        },

        methods: {


            //updateSelect() @set-fields

            submitCreate(){
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
            if(1) _log('mounted', {
                'vue-name': '<?=$vueName?>',
                'self-url': '<?=kot('hp', 'namedUrl', $vueName)?>',
            })


        },
    }
})