<?
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
        },

        data(){
            //_log('data');
            return {

            }
        },

        methods: {

            login: function(){
                var self = this;
                var Login = this.$refs.login;
                var Pass = this.$refs.password;
                Login.shake();
                ApiKot.post('login/submit', { login: Login.input, password: Pass.input }, function(responseData){
                    ///self.$emit('onAccess', response.access_token);
                    //BusKot.emit('AccessToken', response.access_token);
                    BusKot.emit('AccessToken', responseData.access_token);
                    //this._aKot('app', 'overlay', true);
                }, { emu: true })

            }
        },



        mounted(){
            //_log('mounted')
        },
    }
})