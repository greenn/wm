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

        emits: [
            'onRemove',
            //'onSubmit',
            //'assignData',
            'onChange',
        ], //onClose

        props: [
            'on_mount',
            //'saved',
            'initData',
        ],

        data(){
            //_log('data', { 'props.setData': _clone(this.$props.setData), setData: _clone(this.setData)});

            var cfg = {
                id: 0,

                passes_min: 0,
                'passes_min-fix': false,

                interval: '',

                station: '',
                'station-fix': true,

                //from: _getCurrentDateTime({ week: -1 }, true),
                'from_preset': '',
                'from-fix': true,

                //to: _getCurrentDateTime(true, true),
                'to_preset': '',
                'to-fix': true,
            };
            return {
                //cfg: _.extend(cfg, this.$props.setData),
                cfg: cfg,

                ready: false,
                wait: {
                    interval: false,
                    station: false,
                },
            }
        },

        methods: {
            fetchData: function(data){
                _.merge(this.cfg, data, function(selfValue, newValue) {
                    if (_.isUndefined(newValue)) {
                        return selfValue;
                    }
                })
            },

            onReady: function(){
                //_log('isReady');
                if (this.initData) {
                    //step: fetchInitData
                    if (typeof this.initData === 'function') {
                        this.initData.call(this)
                    } else {
                        this.fetchData(this.initData);
                    }
                }

                this.ready = true;
            }
        },

        watch: {
            wait: {
                deep: true,
                handler: function(val) {
                    var ready = _.every(this.wait); //проверяем каждое ли значение true
                    //_log('w:wait', { ready, val: _clone(val) })
                    if (ready) this.onReady();
                },
            },

            cfg: {
                deep: true,
                handler: function(val){
                    //_log('w:cfg', { cfg: this.cfg, _cfg: _cc(this.cfg), ready: this.ready });
                    if (this.ready) {
                        //_log('onChange', { data: this.cfg });
                        this.$emit('onChange', this.cfg)
                    }
                }
            }
        },

        mounted(){
            //_log('mounted', { initData: this.initData, _initData: _cc(this.initData) })
        },
    }
})