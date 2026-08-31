<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();

$css = array();
$cssDir = $Self::path('css');

$theme = proKot('theme');
//$theme = gt_on('theme', proKot('theme'));
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    $css['layout'] = "$cssDir/layout.css.inc",
    $css['layout-theme'] = "$cssDir/app.$theme.css.inc",
    $css['popup'] = "$cssDir/popup.css.inc",
    $css['http-errors'] = "$cssDir/http-errors.css.inc",
    __FILE__
));
//oo kot/r/app/css/layout.dhaka.css.inc
?>
<? if(is_file($css['layout'])) include $css['layout'] ?>
<? if(is_file($css['layout-theme'])) include $css['layout-theme'] ?>

<? //include $css['popup'] ?>

<? include $css['http-errors'] ?>

@media (max-width: <?=_mq(2)?>px) {}