<?
$Self = _kot::self();
$nB = $Self::nc('button');
$Self::req_css(-1, 'buttons');
?>
<button
        @click="$emit('click')"
        class="<?=$nB?>"
        <?//v-bind="attrs" нужно видимо при inheritAttrs: false,?>
        :class="[{ '-disabled': disabled }, cssClass]"

        @mouseover="hover = true"
        @mouseleave="hover = false"
        @mousedown="click = true"
        @mouseup="click = false"
>
    <template v-if="!busy">

        <template v-if="$slots.default">
            <slot></slot>
        </template>
        <template v-else>
            {{ text }}
        </template>

    </template>
    <template v-else>
        <span>-busy-</span>
    </template>
</button>