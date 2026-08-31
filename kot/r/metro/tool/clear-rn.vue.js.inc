<?
$Self = _kot::self();
//$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
$vueName = prop($Self::tempCtx(), 'id', 'tool-clear-rn')
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    var nv = '<?=$vueName?>';

    return {
        _vue: {
            //provide: [],
        },

        data(){

            var defInput = "src\r\nnewline";
            defInput = Store.getOr([nv, 'input'], defInput);

            return {
                input: defInput,
                opt: {
                    tiret: true,
                    ol: true,
                },
                output: '',
                //output_note: '',
                output_note: 'Скопированно в буффер',
            }
        },

        methods: {
            genOutput(){
                var _opt = this.opt;
                var str = this.input;


                str = str.replace(/[\n\r]/g, ' ');
                str = str.replace(/\s+/g, ' ');
                if (_opt.tiret) {
                    str = str.replace(/([-−—]\s)/g, '\r\n$1');
                }

                if (_opt.ol){
                    str = str.replace(/([\d]+[.]\s)/g, '\r\n$1');
                }

                this.output = str;

                //_log('genOutput', { str, input: this.input, output: this.output })
            },

            onOutputClick: function(){
                _log('onOutputClick');
                this.$refs.output.select();

                if (true) {
                    document.execCommand("copy");

                    if (true) {
                        var self = this;
                        //this.outputNote('Скопированно в буффер')
                        this.output_note = 'Скопированно в буффер';
                        setTimeout(function(){
                            self.output_note = '';
                        }, 1000)
                    }
                }

            }

        },

        watch: {
            input: function(value){
                //keepLocal | saveLocal
                Store.set([nv, 'input'], value);

                this.genOutput();
            }
        },

        mounted(){
            this.genOutput();
        }
    }
})