<?
$Self = _kot::self();
$nB = $Self::nc('button');
$Self::req_css(-1, 'buttons');
?>
<button
        @click="!disabled && $emit('click')"
        class="<?=$nB?>"
        <?//v-bind="attrs" нужно видимо при inheritAttrs: false,?>
        :class="[{ '-disabled': disabled }, cssClass]"

        @mouseover="hover = true; $emit('hover', true)"
        @mouseleave="hover = false; $emit('hover', false)"
        @mousedown="click = true"
        @mouseup="click = false"
>
    <div fxr fxi="c" class="<?=$nB?>-c">
        <slot></slot>
    </div>
</button>