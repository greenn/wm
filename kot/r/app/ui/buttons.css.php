<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg

$Self = _kot::self();
$nB = $Self::nc('button');

$nIM = $Self::nc('IcM'); //icon-mat

$tr = _cssKot('tr0');
$trq = _cssKot('trq1');

$f1_ = _cssKot('fM_');


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.ft-button {
    font-family: <?=$f1_?>;
    font-size: 13px;

}
.<?=$nB?>[b-button] .ft-button {
    text-transform: uppercase;
}


.<?=$nB?>[b-button],
.<?=$nB?>[b-button] * {
    color: <?=_cssKot('white')?>;;
}

.<?=$nB?>[s-button],
.<?=$nB?>[s-button] * {
    color: <?='black'?>;
}

.<?=$nB?>[s-button].-hover {
    background: lightgrey;
}
.<?=$nB?>[s-button].-selected {
    background: lightyellow;
}

<?//[class^="material-icons"], [class^="material-symbols"],?>
.<?=$nB?> .<?=$nIM?> {
    cursor: pointer;
    overflow: hidden;
}
.<?=$nB?> .<?=$nIM?> [icon] {
    font-size: 9px;
    max-width: 10px; <?// для предотвращения растягивания при загрузке шрифта?>
}

.<?=$nB?> > * {
    vertical-align: middle;
}

.<?=$nB?> {
    border-style: none;
    border-color: <?=_cssKot('bu-button-bc')?>;
    background-color: <?=_cssKot('bu-button-bg')?>;
    color: <?=_cssKot('white')?>;
}



.<?=$nB?>.-disabled {
    cursor: default;

    background-color: rgba(0, 0, 0, 0.12) !important;

    <?=pcss('transition', array(
        'background 400ms cubic-bezier(0.25, 0.8, 0.25, 1)',
        'box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1)',
    ))?>

    <?=pcss('box-shadow', array(
        '0px 0px 0px 0px rgba(0, 0, 0, 0.2)',
        '0px 0px 0px 0px rgba(0, 0, 0, 0.14)',
        '0px 0px 0px 0px rgba(0, 0, 0, 0.12)',
    ))?>
}

.<?=$nB?>.-disabled,
.<?=$nB?>.-disabled * {
    color: rgba(0, 0, 0, 0.26) !important;
}


.<?=$nB?> [icon] + span {
    padding-left: 6px;
}

.<?=$nB?> {
    padding: 6px 11px;
    border-radius: 5px;
    border-radius: 10% / 50%;
    border-radius: 50% 20% / 10% 40%;
    transition: border-radius <?=$trq?>;
    /*border-radius: 15px;*/
}


.<?=$nB?>.-mr {
    margin-right: 7px;
}

.<?=$nB?>[small] {
    padding: 2px 5px;
    border-radius: 10% / 50%;
}
.<?=$nB?>[small="rev"] {
    border-radius: 50% / 10%;
}

.<?=$nB?>[small].-mr {
    margin-right: 2px;
}


.<?=$nB?>[bu-button] {
    border-color: <?=_cssKot('bu-button-bc')?>;
    background-color: <?=_cssKot('bu-button-bg')?>;
}

.<?=$nB?>[b-button] {
    border-color: <?=_cssKot('b-button-bc')?>;
    background-color: <?=_cssKot('b-button-bg')?>;
}

.<?=$nB?>[s-button] {
    border-color: rgb(0 0 0 / 8%);
    background-color: <?=_cssKot('s-button-bg')?>;
    border-width: 1px;
    border-radius: 10px;
    border-style: solid;
    padding: 0 4px; <?//small?>
}
.<?=$nB?>[s-button][small].-click,
.<?=$nB?>[s-button].-click {}

.<?=$nB?>[bu-button].-click {
    border-radius: 55% 25% / 15% 45%;
}
.<?=$nB?>[bu-button][small].-click {
    padding: 2px 5px;
    border-radius: 10% / 50%;
}
.<?=$nB?>[bu-button][small="rev"].-click {
    border-radius: 50% / 10%;
}

.<?=$nB?>.-click .<?=$nB?>-c { top: 1px; }
.<?=$nB?>[clk*="t"].-click .<?=$nB?>-c { top: -1px; }
.<?=$nB?>[clk*="l"].-click .<?=$nB?>-c { left: -1px; }
.<?=$nB?>[clk*="r"].-click .<?=$nB?>-c { left: 1px; }

.<?=$nB?>.-click .<?=$nB?>-c {
    top: 1px;
}

.<?=$nB?>-c {
    opacity: 1;
    <?=pcss('transition', "opacity $trq")?>
}

.<?=$nB?>.-busy .<?=$nB?>-c {
    opacity: 0.1;
}

<? $s1 = 6; $s2 = 12 ?>
.<?=$nB?>-spinner {
    width: <?=$s1?>px;
    height: <?=$s1?>px;
    border-radius: 50%;
    background-color: #fff;
    box-shadow: <?=$s2?>px 0 #fff, -<?=$s2?>px 0 #fff;
    position: relative;
    animation: <?=$nB?>-flash 0.5s ease-out infinite alternate;
}

@keyframes <?=$nB?>-flash {
    0% {
        background-color: #FFF2;
        box-shadow: <?=$s2?>px 0 #FFF2, -<?=$s2?>px 0 #FFF;
    }
    50% {
        background-color: #FFF;
        box-shadow: <?=$s2?>px 0 #FFF2, -<?=$s2?>px 0 #FFF2;
    }
    100% {
        background-color: #FFF2;
        box-shadow: <?=$s2?>px 0 #FFF, -<?=$s2?>px 0 #FFF2;
    }
}


@media (max-width: <?=_mq(2)?>px) {}