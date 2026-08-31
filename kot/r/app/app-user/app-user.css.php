<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$n = $Self::nc();
$nHS = $Self::nc('HS'); //head-snippet

$f1_ = _cssKot('fM_');

//$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
.ft-user-name {
    font-family: <?=$f1_?>;
    font-size: 13px;
    line-height: 10px;
    font-weight: 700;
}

.ft-user-type {
    font-family: <?=$f1_?>;
    font-size: 11px;
    line-height: 14px;
    font-weight: 300;
    letter-spacing: -.5px;
    color: #9296ac;
}

.<?=$nHS?>-ava-pic {
    width: 33px;
    height: 33px;
    border-radius: <?=33/2?>px;
    border: 1px solid <?=_cssKot('white')?>; /* Первая граница */
    box-shadow: 0 0 0 1px <?=_cssKot('b-button-bc')?>; /* Вторая граница */

    overflow: hidden;
}

.<?=$nHS?>-ava-pic IMG {
    width: 100%;
}

.<?=$nHS?>.-load .<?=$nHS?>-ava-pic IMG {
    opacity: .7;
}

.<?=$nHS?>-info {
    min-width: 60px;
    margin-left: 10px;
}