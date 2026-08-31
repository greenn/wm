<?
$Self = _kot::self();
$vueName = basename(__FILE__, '.vue.js.inc');
//man https://fonts.google.com/icons?selected=Material+Symbols+Outlined:chevron_left:FILL@0;wght@400;GRAD@0;opsz@48
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        prop: [
            'name',
            'tooltip',
            'tooltip_msg',
            'tooltip_hover',
        ],

        data(){
            return {
                defName: 'emoticon'
            }
        },

        methods: {},

        mounted(){
            this.log('mounted')
        },
    }
})