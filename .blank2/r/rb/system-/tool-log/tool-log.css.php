<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
    _needphp('pcss');
    _needphp('css/dec', 'css/vu');

    $Self = self_rp();
    $nTL = $Self::nc('tool-log');
    $nTL_H = $Self::nc('tool-log-head');
    $nTL_C = $Self::nc('tool-log-content');
    $nTL_U = $Self::nc('tool-log-users');
    $nTL_S = $Self::nc('tool-log-sessions');
    $nTL_R = $Self::nc('tool-log-requests');
    $nTL_F = $Self::nc('tool-log-filter');

    $tr = data_css('tr0');

    headers('css', 'utf8', 'nosniff', etag::ctx(
        pcss_etag_ctx('transition'),
        etag::extra(
            $nTL, $nTL_H, $nTL_C,
            $nTL_U, $nTL_S, $nTL_R,
            $nTL_F,
            $tr
        ),
        __FILE__
    ), SITE_CACHE);
?>

.<?=$nTL?> {}

<?//                Head                   ?>

.<?=$nTL_H?> {
    height: 330px;
    overflow: scroll;
    position: relative;
}

.<?=$nTL_H?> .-selected A {
    color: orangered;
}

.<?=$nTL_H?> > ._col {
    display: block;
    width: 33%;
    float: left;
    -outline: 1px solid blue;
}


.<?=$nTL_H?> .col-w {
    padding: 10px 20px;
}

<?//                Users                   ?>

<?/*[no] A.<?=$nTL_U?>-link::first-letter { */?>
.<?=$nTL_S?> H2 I:first-letter,
A.<?=$nTL_U?>-link .first-letter {
    font-size: 130%;
    color: orangered !important;
}

<?//                Filter                   ?>


.<?=$nTL_F?> {
    display: table;
    margin: 0 auto;
}
.<?=$nTL_F?> BUTTON {
    margin: 5px;
}

.<?=$nTL_F?> BUTTON.-pressed {
    border-style: inset;
}

<?//                Content                   ?>

.<?=$nTL_C?> H3.-msg {
    color: #250fe2;
}

.<?=$nTL_C?> H3.-error {
    color: red;
}

.<?=$nTL_C?> H3.-log {
    color: green;
}