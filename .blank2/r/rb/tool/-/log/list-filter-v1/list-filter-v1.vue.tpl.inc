<?
$self_nc = 'tool-log';
$Self = _rw::name($self_nc);
$nF = $Self::nc('filter');

_source::req_cmpt('rw', $self_nc, 'filter-button', 2);
?>
<div class="<?=$nF?>">
    <div fxr>
        <span
            :class="{ '-hover': label.hover }"
            @mouseover="label.hover = true" @mouseleave="label.hover = false"
        >{{ label.text }}: {{ hasFilter }}</span>
        <template v-for="(button, index) in buttons" :key="index"
                  :item="button">
            <button :class="{ '-pressed': button.selected }" @click="button.press(button)">{{ button.text }}, {{ button.selected }}</button>
        </template>
    </div>
</div>