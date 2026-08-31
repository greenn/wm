<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$n = $Self::nc();

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));

$pic = 'banner/1/banner.png';
?>
.ft-banner-title {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('white')?>;
    color: <?='#b3cddb'?>;
    font-size: 18px;
    font-weight: 500;
}
.ft-banner-phone {
    font-family: <?=_css('f2_')?>;
    color: <?=_css('white')?>;

    font-size: 22px;
    font-weight: 500;
}

.<?=$n?>-cover IMG {
    width: 100%;
    max-width: <?=_i::w($pic)?>px;
}

.<?=$n?>-content {
    top: 55px;
    left: 44px;
    width: 200px;
    height: 100px;
}


<? if (0) { ?>
    .<?=$n?> {

        background-image: url('<?=_i::uri($pic)?>');
        background-repeat: no-repeat;
        background-position: center top;
    }
<? } ?>