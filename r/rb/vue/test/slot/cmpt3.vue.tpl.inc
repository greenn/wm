<?
    $Self = _rb::self();
    $nCS3 = $Self::nc('cmpt-slot-3');
?>
<ul>
    <li v-for="(item, index) in items">
	    <? if (0) { ?>{{ item }}<? } ?>
        <? if (0) { ?><slot :item="item"></slot><? } ?>
        <slot
            :item="item"
            :index="index"
            <? if (0) { ?>:another-attribute="anotherAttribute"<? } ?>
        ></slot>
    </li>
</ul>