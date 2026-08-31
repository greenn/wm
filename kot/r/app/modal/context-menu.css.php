<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$nCM = $Self::nc('context-menu');

$B_n = kot('ui', 'nc', 'button');

$tr = _cssKot('tr0');

$css = array();
$cssDir = $Self::path(); //same $Self::relDir();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
     $css['eff'] = "$cssDir/context-menu.css.inc",
    __FILE__
));
?>



.<?=$nCM?>-w {
    left: 10px;
    bottom: 5px;
}

.<?=$nCM?> *[class*="ft-"] {
    color: rgba(0, 0, 0, 0.87);
}

.<?=$nCM?>-w {
    left: 10px;
    top: 100%;
    margin-top: -5px;
}

.<?=$nCM?> {
    min-width: 200px;
    border-radius: 4px;
    background-color: white;

    <?=pcss('box-shadow', array(
        '0px 2px 4px -1px rgba(0, 0, 0, 0.2)',
        '0px 4px 5px 0px rgba(0, 0, 0, 0.14)',
        '0px 1px 10px 0px rgba(0, 0, 0, 0.12)',
    ))?>
}

.<?=$nCM?>-item.<?=$B_n?> {
    width: 100%;
}
.<?=$nCM?>-item .<?=$B_n?>-с {
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 3px;
    padding-right: 12px;
}

.<?=$nCM?>-item.-hover {
    background-color: rgba(0, 0, 0, 0.04);
}
.<?=$nCM?>-item.-click {
    background-color: #dcdcdc;
}

.<?=$nCM?>-icon {
    text-align: center;
    width: 22px;
    height: 22px;
    padding: 0 5px;
}

.<?=$nCM?>-icon .material-icons {
    vertical-align: middle;
    line-height: 23px;
    color: rgba(0, 0, 0, 0.54);
}
