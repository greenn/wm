<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$n = $Self::nc();

$n_LS = kot('ui', 'nc', 'LS'); //lay-section
//$tr = _cssKot('tr0');

//$hSep = _cssKot('section-cell-sep'); //— | $hSep|$sepCell ~20

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


.<?=$n?>-cmd,
.<?=$n?>-title {
    min-height: 33px;
}

.<?=$n?>.-hasSubTitle .<?=$n?>-cmd,
.<?=$n?>.-hasSubTitle .<?=$n?>-title {
    min-height: 55px;
}

.<?=$n?>-cmd-base {
    padding-top: 4px;
}

.<?=$n?>-cmd-item {
    margin-bottom: 2px
}

.<?=$n?>-user {}