<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();
$nL = $Self::nc('legend');

$nT2 = $Self::nc('T2');
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {},

        data(){
            //_log('data');


            return {
                points: [
                    {
                        'checked': false,
                        'text': [
                            'оставить <span class="<?=$nL?>-field">значение</span> настраиваемым,',
                            'указанное значение будет по умолчанию'
                        ].join('<br />')
                    },
                    {
                        'checked': true,
                        'text': [
                            'зафиксировать указаное <span class="<?=$nL?>-fix">значение</span> в шаблоне',
                        ].join('<br />')
                    }
                ]
            }
        },

        methods: {},

        mounted(){},
    }
})