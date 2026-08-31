<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'link', 'linkBack',
            ],
        },

        data(){
            //_log('data');
            return {
                target1: {
                    "id": 0,
                    "passes_min": "1",
                    "passes_min-fix": true,
                    "interval": "last-30d",
                    "station": [
                        "437"
                    ],
                    "station-fix": true,
                    //"from_preset": "",
                    "from-fix": true,
                    //"to_preset": "",
                    "to-fix": true,
                    "to": "2023-09-02",
                    "from": "2023-08-03"
                },

                target2: {
                    "id": 0,
                    "passes_min": "1",
                    "passes_min-fix": true,
                    "interval": "last-30d",

                    //"from-fix": true,
                    //"to-fix": true,
                    //"to": "2023-09-02",
                    //"from": "2023-08-03"
                }
            }
        },

        methods: {

            update(targetProp, data){
                this[targetProp] = data;
            },


            remove1(){
                _log('remove1')
            },
            vlaidate1(){
                _log('remove1')
            },

            update1(data){
                this.target1 = data;
            },
        },

        mounted(){
            //var target1 = this.$refs.target1;
            //_log('mounted', { target1: target1, 'target1.validate': target1.validate })
        },
    }
})