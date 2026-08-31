<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
//$n = $Self::nc();
$nF = $Self::nc('footer-menu');

$tr = _css('tr0');
//$oo = gt_on('oo'); //dbg

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>
.ft-menu-footer {
    font-family: <?=_css('f1_')?>;
    font-size: 15px;
    color: <?=_css('tc-base')?>;
    line-height: 17px;
    font-weight: 500;
}


.<?=$nF?>-icon-w {
    height: 50px;
}

.<?=$nF?>-icon IMG {
    max-height: 40px;
    max-width: 90%;
}