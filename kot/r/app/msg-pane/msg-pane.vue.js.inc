<?//mb ak Gus
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
            store: [
                'status',
                'opt',
                'status_index',
                'status_list',
            ],
            _store: {
                //reset: ['opt']
                reset: ['status'],
                //reset: ['status_index', 'status_list']
            }
        },

        data(){
            //_log('data');
            return {
                status_index: '',
                status_list: [],
                opt: {
                    'auto-reset': false,
                },
            }
        },

        methods: {

            showStatus(status, ref){
                //_log('showStatus', { status, auto: this.opt['auto-reset'] });
                if (this.opt['auto-reset']) this.resetStatus();

                this.status_list.push({ value: status, ref: ref });
                this.status_index = this.status_list.length - 1;
            },

            resetStatus(){
                this.status_list = [];
                this.status_index = '';
            },
            
            selectNextIndex(jump){
                var nextIndex = this.status_index + (jump || 1);
                if (nextIndex >= this.status_list.length) {
                    nextIndex = this.status_list.length - 1; //lastIndex
                }
                this.status_index = nextIndex;
            },
            selectPrevIndex(jump){
                var prevIndex = this.status_index - (jump || 1);
                if (prevIndex < 0) prevIndex = 0; //firstIndex
                this.status_index = prevIndex;
            },

            handleKeydown(event){
                switch (event.key) {
                    case 'ArrowLeft': case 'Numpad4': case '4':
                        this.selectPrevIndex();
                        break;
                    case 'ArrowRight': case 'Numpad6': case '6':
                        this.selectNextIndex();
                        break;
                    case 'ArrowUp': case 'Numpad8': case '8':
                        this.selectPrevIndex(7);
                        break;
                    case 'ArrowDown': case 'Numpad2': case '2':
                        this.selectNextIndex(7);
                        break;

                    case 'Numpad9': case '9':
                        this.selectPrevIndex(6);
                        break;
                    case 'Numpad7': case '7':
                        this.selectPrevIndex(8);
                        break;
                    case 'Numpad3': case '3':
                        this.selectNextIndex(8);
                        break;
                    case 'Numpad1': case '1':
                        this.selectNextIndex(6);
                        break;

                    default:
                        return; // Выход из функции, если нажата другая клавиша
                }
            }

        },

        mounted(){
            //_log('mounted', { $el: this.$el })

            $(this.$el).focus();

        },
    }
})