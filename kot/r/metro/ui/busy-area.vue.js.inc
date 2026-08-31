<?
$Self = _kot::self()
?>
_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        props: ['busy'],
        emits: ['extraClose'],
    }
})