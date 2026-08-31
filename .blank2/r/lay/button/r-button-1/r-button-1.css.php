<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _lay::self();
$nRB1 = $Self::nc('RB1');

$tr = css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));

$cs = new _cssVars(array(
	'cg0' => '#c6d9dc',
	'cg1' => '#b5c9cd',
	//'cg0' => css('blue'),
	//'cg1' => css('blue'),
    'cg0_pct' => '0%',
	'cg1_pct' => '100%',
	'h_cg0' => '#aadeeb',
	'h_cg1' => '#8fcee1',
	'ct' => '#005771',
	'h_ct' => '#327c93',
	'fs' => '14px',
	'pv' => '20px',
	'ph' => '50px',
	'bx' => '14px 14px 5px -12px rgba(0,0,0,0.1)', //box-shadow
	'bc' => '', //border-color
	'h_bc' => '', //border-color on hover
	'bs' => '0', //border-size
	//'br' => '' //~ calc
), 'rb1-', true);

$br = floor(($cs->int('fs') + $cs->int('pv') + $cs->int('ph')) / 2);
$cs->set('br', $br, 'px');
//$cs->br = floor(($cs->int('fs') + $cs->int('pv') + $cs->int('ph')) / 2);
//$cs->setUnit('br', 'px');
//$cs->set('br', floor(($cs->int('fs') + $cs->int('pv') + $cs->int('ph')) / 2), 'px');
?>

.<?=$nRB1?> {
    <?// --rb1-cg0: #c6d9dc; ?>
    <?=$cs?>
}


.ft-rbutton-1 {
    font-size: <?=$cs->_var('fs')?>;
    font-weight: 300;
    color: <?=$cs->_var('ct')?>;
}

<? if (0) { //01?>
    .<?=$nRB1?> .ft-rbutton-1 {
        color: <?=$cs->_var('ct')?>;
    }
<? } ?>


.<?=$nRB1?> {
    <?=pcss('transition', array(
        "background $tr",
        "padding $tr",
        "border-radius $tr",
        "border-width $tr",
        "border-color $tr",
    ))?>
    box-shadow: <?=$cs->_var('bx')?>;

<?/*
    background: linear-gradient(to bottom, <?=$cg0?> 0%, #fff 50%, <?=$cg1?> 100%);
    background: linear-gradient(to bottom, <?=$cg0?> 0%, <?=$cg1?> 100%);
*/?>

    padding: <?=$cs->_var('pv')?> <?=$cs->_var('ph')?>;
    border-radius: <?=$cs->_var('br')?>;


}


.<?=$nRB1?>,
.<?=$nRB1?> .<?=$nRB1?>-bg,
.<?=$nRB1?> .<?=$nRB1?>-hover {
    border-width: <?=$cs->_var('bs')?>;
    border-color: <?=$cs->_var('bc')?>;
    border-style: solid;
}


.<?=$nRB1?>-bg {
    border-radius: <?=$cs->_var('br')?>;
    opacity: 1;
    background: linear-gradient(to bottom, <?=$cs->_var('cg0')?> <?=$cs->_var('cg1_pct')?>, <?=$cs->_var('cg1')?> <?=$cs->_var('cg1_pct')?>);
    <?=pcss('transition', array(
        "opacity $tr",
    ))?>
}
.<?=$nRB1?>-hover {
    border-radius: <?=$cs->_var('br')?>;
    opacity: 0;
    <?=pcss('transition', array(
        "opacity $tr",
        //"opacity {$cs->_var('h_at')} {$cs->_var('h_ae')}",
    ))?>
    background: linear-gradient(to bottom, <?=$cs->_var('h_cg0')?> <?=$cs->_var('cg0_pct')?>, <?=$cs->_var('h_cg1')?> <?=$cs->_var('cg1_pct')?>);
}

.<?=$nRB1?>:hover {
    border-color: <?=$cs->_var('h_bc')?>;
}

.<?=$nRB1?>:hover .<?=$nRB1?>-bg {
    -opacity: 0;
}
.<?=$nRB1?>:hover .<?=$nRB1?>-hover {
    opacity: 1;
}
.<?=$nRB1?>:hover [class*="ft-"] {
    color: <?=$cs->_var('h_ct')?>;
}

@media (max-width: <?=_mq(2)?>px) {}