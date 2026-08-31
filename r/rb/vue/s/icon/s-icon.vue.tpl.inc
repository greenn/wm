<?
//$Self = _rb::self();
?>
<button
    @click="$emit('click')"
    :class="[$attrs.class, cssClass]"
    :style="[$attrs.style, css]"
    v-bind="attrs"
    @mouseover="hoverIn(), hover = true"
    @mouseleave="hoverOut(), hover = false"
    @mousedown="mouseDown"
    @mouseup="mouseUp"
    <?//r есть, если не передан a?>
>
    <img :src="src" :alt="alt">
</button>