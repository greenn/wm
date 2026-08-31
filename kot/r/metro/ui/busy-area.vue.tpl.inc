<?
$Self = _kot::self();
$nBA = $Self::nc('BA'); //busy-area
$Self::req_css('ui');
?>
<transition name="fade">
    <div class="<?=$nBA?>"
        :class="[$attrs.class]"
        @dblclick="$emit('extraClose')"
        v-if="busy"
    >
        <div avh class="<?=$nBA?>-spinner"></div>
        <?/*<div avh class="<?=$nC?>-spinner">
            <?=kot_i::svg('busy/loader/Rolling-0.8s-200px.svg', '')?>
        </div>*/?>
    </div>
</transition>