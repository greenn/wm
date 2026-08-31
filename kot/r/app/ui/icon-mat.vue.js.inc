<?
/*
man
	https://fonts.google.com/icons
	https://fonts.google.com/icons?selected=Material+Symbols+Outlined:chevron_left:FILL@0;wght@400;GRAD@0;opsz@48

doc
    https://developers.google.com/fonts/docs/material_symbols?hl=ru
    https://m3.material.io/styles/icons/overview

eg
    kot/r-test/icon-mat.tpl.inc
*/

$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        props: [
            'dbg',
            'tooltip',
                //'tooltip_msg',
                //'tooltip_hover',
        ],

        data(){
            return {
                isHover: false
            }
        },

        methods: {},

        mounted(){
            if (this.dbg) this.log('mounted', { tooltip })
        },
    }
})