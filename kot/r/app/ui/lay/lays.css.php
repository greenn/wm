<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
    'headers',
    'ns.class'
);

$Self = _kot::self();
$nLS = $Self::nc('LS'); //lay-section

$tr = _cssKot('tr0');
$trq = _cssKot('trq1');

$ph0 = _cssKot('app-ph'); // —
$ph0h = floor($ph0 / 2);

$p = _cssKot('section-p'); // —
///$bg0 = _cssKot('section-bg');

//dx(nso('ol', 0, 2), nso('ol', 1, 2));
//dx(nso(array('od', 'o2'), 0, 2), nso('o2', 1, 2));

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nLS?> {
    background-color: <?=_cssKot('section-bg')?>;
    border: 1px solid <?=_cssKot('section-bc')?>;
    padding: <?=$p?>px;
    <?=pcss('border-radius', _cssKot('section-br').'px')?>
}

.<?=$nLS?>[tight] {
    padding-top: <?=$p / 2?>px;
    padding-bottom: <?=$p / 2?>px;
}


.<?=$nLS?>-headline-w {
    padding-bottom: 10px;
}

.<?=$nLS?>-headline-w.no-content {
    padding-bottom: 0;
}


.<?=$nLS?>.-half {
    width: 50%;
}

.<?=$nLS?>[flt].-half {
    width: calc(50% - <?=$ph0h + $p * 2?>px);
}

.<?=$nLS?>[flt].-half.-od {
    margin-right: <?=$ph0h?>px;
}

.<?=$nLS?>[flt].-half.-o2 {
    margin-left: <?=$ph0h?>px;
}