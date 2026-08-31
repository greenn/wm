<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$n = $Self::nc();
$nH = $Self::nc('head');

$f1_ = _cssKot('fM_');

$n_UHS = kot('app-user', 'nc', 'HS');

//$tr = _cssKot('tr0');


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
.ft-logo {
    font-family: <?=$f1_?>;
    font-size: 13px;
}

.ft-logo-v {
    font-family: <?=$f1_?>;
    font-size: 12px;
    font-weight: 300;
}

.<?=$nH?>-logo {
    margin-left: <?=_cssKot('section-cell-sep') ?>px;
    margin-right: <?=_cssKot('section-cell-sep') / 2?>px;
    width: 50px;
}

.<?=$nH?>-logo-title-aim {
    margin-right: 2px;
}

.<?=$nH?>-logo IMG {
    width: 90%;
    margin: 0 auto;
}

.<?=$n?> {
    padding-left: 6px;
    padding-right: 6px;
}

.<?=$n?>-user {
    margin: 0 10px;
}

.<?=$n?>-user .<?=$n_UHS?>-ava {
    margin-left: 16px;
    margin-right: 6px;
}


[indent="<?=$n?>-after-head"] {
    height: <?=_cssKot('section-row-sep')?>px;
}
