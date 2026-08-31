<?
    $Self = _rw::name('tool-log');
    $nF = $Self::nc('filter');

    $nFB = $Self::nc('filter-button');
?>
<button
    class="<?=$nFB?>"
    :class="{ '-pressed': selected }"
    @click="click">{{ text }}, {{ selected }}
</button>