<?
/*
    oo site/css/inc/reset.css.inc
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
//$Self = _rb::self();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
), SITE_CACHE);
?>

HTML, BODY {
    /*height: 100%;*/
    margin: 0;
}

HTML.h-overflow,
BODY.h-overflow {
    min-height: 100%;
}

BUTTON {
    outline: none;
    cursor: pointer;
}

P {
    margin-block-start: unset;
    margin-block-end: unset;
}

PRE {
    display: block;
}

H1, H2, H3, H4, H5, H6 {
    font-weight: inherit;
    /*line-height: 100%;*/
}
H1, H2, H3, H4, H5, H6,
DL, DT, DD,
UL, OL,
PRE {
    margin-top: 0;
    margin-bottom: 0;
}
DL {
    margin-block-start: 0;
    margin-block-end: 0;
    margin-inline-start: 0;
    margin-inline-end: 0;
}
DD {
    margin-left: 0;
}
UL {
    padding-left: 0;
}

LI[rst="li"], LI.rst-li,
[rst="li"] LI, .rst-li LI {
    list-style-type: none;
    list-style-position: inside;
}

FORM[rst], FORM.rst {
    margin-bottom: 0;
}

/*BUTTON[rst], BUTTON.rst*/
[rst="button"], [rst="btn"], .rst-btn {
    background: none;
    border: none;
    padding: 0;
}

TABLE[rst], TABLE.rst {
    border-collapse: collapse;
    border-spacing: 0;
}
<? foreach (explode(',', 'table,caption,tbody,tfoot,thead,tr,th,td') as $tag) { ?>
<? //foreach (explode(',', '> caption,> tbody,> tfoot,> thead,> tr, > tr > th, > tr > td') as $tag) { ?>
TABLE[rst], TABLE.rst <?=strtoupper($tag)?>,
<? } ?>
TABLE[rst], TABLE.rst {
    margin: 0;
    padding: 0;
    border: 0;
    /*vertical-align: baseline;*/
}
TABLE[rst="va"] TD,
TABLE[rst="va"] TH {
    vertical-align: top;
}

IFRAME.rst {

}

[rst="input"], .rst-input {
    background: transparent;
    border: 0;
    padding: 0;
    outline: none;
}

[rst="select"] {
    border: 0;
    outline: none;
}


TEXTAREA[rst],
[rst="textarea"] {
    border: 0;
    outline: none;
}



BLOCKQUOTE[rst] {
    margin: 0;
    padding: 0;
    font-style: normal;
    quotes: none;
}
FIGCAPTION[rst] {
    font-style: normal;
}