<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/css/tool-css.class.php';
_needphp('headers', 'pcss');

$Self = _rw::name('tool-css');
$nCV = $Self::nc('calc-vu');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));

?>

.<?=$nCV?> {
    display: table;
    border-left: 2px solid darkslategray;
    padding-left: 7px;
    margin: 7px;
}
.<?=$nCV?> * {
    font-size: 14px;
}

.<?=$nCV?> H2 {
    margin-bottom: 7px;
}

.<?=$nCV?>-w {
    <?=pcss('display', 'inline-flex')?>
    <?=pcss('flex-direction', 'row')?>
    <?=pcss('flex-wrap', 'nowrap')?>
}
.<?=$nCV?>-col {
    min-width: 63px;
    margin-right: 3px;
}

.<?=$nCV?>-col[input] {}

.<?=$nCV?> LABEL {
    color: grey;
    font-style: italic;
    display: block;
}

.<?=$nCV?> INPUT {
    border: none;
    outline: none;
    border-bottom: 1px solid burlywood;
}
