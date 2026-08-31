<?
$Self = _site::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){
    //_log.set('loadItems', 0);

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
        },

        data(){
            //_log('data');
            return {
                isResultPage: false,

                inputValue: '',
                isFocused: false,
                showResult: false,
                result: false,
                sendQuery: false,
            }
        },

        methods: {

            buttonClick(){
                this.openResultPage();

                return;
                if (!this.isResultPage) {
                    this.openResultPage();
                } else {
                    this.applyQuery();
                }
            },

            openResultPage(){
                location.href = '<?=page('search', 'makeLink');?>' + `?q=${this.inputValue}`;
            },

            applyQuery(){
                _log('search');

                var self = this;
                this.sendQuery = true;
                this.showResult = true;
                this.result = '-';

                SiteApi.request.post('search/query', { text: this.input }, {
                    success: function(response){
                        _log('applyQuery/response', { response, location })

                        var responseData = response.data;
                        self.result = responseData.result;
                        self.sendQuery = false;

                    },
                }, {
                    emu: true
                })
            },

            fakeSearch(){
                var $field = $(this.$refs['search-field'])
                _log('fakeSearch', { $refs: _cc(this.$refs), $field: $field });
                $field.addClass('shake-404');
                setTimeout(function(){
                    $field.removeClass('shake-404');
                }, 500)

            }

        },

        watch: {
            result(value){}
        },

        mounted(){

            if (_.startsWith(location.pathname, '<?=page('search', 'makeLink')?>')) {
                this.isResultPage = true;

                this.inputValue = location.search.substring(1); //убираем знак ? в начале
            }


        },
    }
})