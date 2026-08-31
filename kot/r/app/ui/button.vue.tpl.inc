<?
$Self = _kot::self();
$nB = $Self::nc('button');
$Self::req_css(-1, 'buttons');
?>
<button r
    @click="!disabled && $emit('click')"
    class="<?=$nB?>"
    <?//v-bind="attrs" нужно видимо при inheritAttrs: false,?>
    :class="[{ '-disabled': disabled, '-busy': busy }, cssClass, ft]"

    @mouseover="hover = true; $emit('hover', true)"
    @mouseleave="hover = false; $emit('hover', false)"
    @mousedown="click = true"
    @mouseup="click = false"
>
    <?// :h="flagBusy ? '' : null" ?>
    <div r fxr fxi="c" class="<?=$nB?>-c" >
        <slot></slot>
    </div>
    <div avh v-show="busy" class="<?=$nB?>-spinner"></div>
</button>