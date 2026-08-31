<?
//$Self = _rb::self();
?>
<button s-toggle @click="status = !status">
    <template v-if="status">
        <span> ˅ </span>
        <slot name="opened"></slot>
    </template>
    <template v-else>
        <span> > </span>
        <slot name="closed"></slot>
    </template>
</button>