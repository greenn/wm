<?
    $Self = _kot::self();
    $nIM = $Self::nc('IcM'); //icon-mat

?>
<? if ($oo) { ?>
    .<?=$nIM?> {
        outline: 1px dashed blue;
    }

    .<?=$nIM?> [icon]{
        outline: 1px dotted orange;
    }
<? } ?>


.<?=$nIM?> [icon]:after {
    content: '';
    display: inline-block;
    position: absolute;
    left: 0; right: 0;
    top: 0; bottom: 0;
}

.<?=$nIM?> {
    cursor: default;
}

.<?=$nIM?>.rotate-90 {
    <?=pcss('transform', 'rotate(90deg) translateX(25%)')?>
}

[small] .<?=$nIM?>.cmd-back [icon] {
    left: 2px;
}

.<?=$nIM?>.-mr [icon],
.material-icons.-mr {
    margin-right: 3px;
}

.<?=$nIM?>.-ot [icon],
.material-icons.-ot {
    position: relative;
    top: 1px;
}
