<?
//$Self = _rb::self();
?>
<button
    s-button
    @click="$emit('click')"
    :class="[$attrs.class, cssClass]"
    v-bind="attrs"
    @mouseover="hover = true"
    @mouseleave="hover = false"
    @mousedown="click = true"
    @mouseup="click = false"
>
    <template v-if="!busy">
        <span>
            <template v-if="$slots.default">
                <slot></slot>
            </template>
            <template v-else>
                {{ text }}
            </template>
        </span>
    </template>
    <template v-else>
        <span>-busy-</span>
    </template>
</button>