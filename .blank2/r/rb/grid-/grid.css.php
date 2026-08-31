<?#4.1.0
    include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
    _needphp('pcss');
    _needphp('css/dec', 'css/vu');
    //_needinc('css/image1px');

    $Self = self_rp();
    $nG = $Self::nc();

    $tr = data_css('tr0');

    headers('css', 'utf8', 'nosniff', etag::ctx(
        pcss_etag_ctx('transition'),
        etag::extra(
            $nG,
            $tr
        ),
        __FILE__
    ), SITE_CACHE);
?>

.<?=$nG?> {
    display: table;
    width: 100%;
    margin: 0 auto;
}

.<?=$nG?>-cell {
    float: left;
    <?=_pcss('transition', array(
        "width $tr",
    ))?>
}

.<?=$nG?>-cell-b { <?//b ak box | w2 | pad | border | boundary ?>
    <?=pcss('transition', array(
        "margin-right $tr",
        "margin-left $tr",
    ))?>
}

.<?=$nG?>-cell-w {
    display: table;
    margin: 0 auto;
    width: 100%;
}

.<?=$nG?>-sep {
    /*display: none;*/
    display: none;
    clear: both;
    width: 100%;
    <?=pcss('transition', array(
        "height $tr",
    ))?>
}


.oo .<?=$nG?> {
    outline: 4px double blueviolet;
}
.oo .<?=$nG?>-cell {
    outline: 1px dotted springgreen;
}
.oo .<?=$nG?>-cell-b {
    outline: 1px dashed midnightblue;
}
.oo .<?=$nG?>-cell-w {
    outline: 1px solid deepskyblue;
}
