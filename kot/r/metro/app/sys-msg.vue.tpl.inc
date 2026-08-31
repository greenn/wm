<?
$Self = _kot::self();
$Self::req_css('sys-msg');
$nSM = $Self::nc('sys-msg');

?>

<div f class="<?=$nSM?>">
    <template v-for="item in list">
        <div
            r fxr
            v-if="item"
            class="<?=$nSM?>-item"
            :class="[item.typeNc, { '-pause': item._hover, '-stop': item._stop }]"
            @mouseover="item.hover(item._hover = true)"
            @mouseleave="item.hover(item._hover = false)"
            @click="item.stop(item._stop = true)"
            @dblclick="item.delete"
        >
            <div a="lt" class="<?=$nSM?>-bar"></div>
            <div a="lt" class="<?=$nSM?>-bar _2"></div>
            <div fg1 class="<?=$nSM?>-item-с">
                <h4 class="ft-msg-head">{{ item.typeTitle }}</h4>
                <p class="ft-msg-text">{{ item.typeMsg }}</p>
            </div>
            <div class="<?=$nSM?>-icon">
            </div>
        </div>
    </template>
</div>


