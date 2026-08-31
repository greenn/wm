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

        <filter-button
            v-for="button in buttons"
            v-bind="button"
            @press="onButtonPress(button, $event)"
        ></filter-button>
    </div>
</div>