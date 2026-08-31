<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
    _needphp('pcss');
    _needphp('css/dec', 'css/vu');

    $Self = self_rp();
    $n = $Self::nc();

    $tr = data_css('tr0');

    headers('css', 'utf8', 'nosniff', etag::ctx(
        pcss_etag_ctx('transition'),
        etag::extra(
            $n,
            $tr
        ),
        __FILE__
    ), SITE_CACHE);
?>
.<?=$n?> {}