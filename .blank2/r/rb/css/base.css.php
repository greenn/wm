<?
/*
    oo site/css/inc/q.css.inc
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
$Self = _rb::self();

$css = array();


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    $css['sh-1'] = $Self::path('sh/sh-haibniu', 'css.inc'),
    $css['sh-2'] = $Self::path('sh/sh-sdthornton', 'css.inc'),
    __FILE__
), SITE_CACHE);
?>
@import '<?=qv($Self::uri('reset.css.php'))?>';
@import '<?=qv($Self::uri('aq.css.php'))?>';
@import '<?=qv($Self::uri('common.css.php'))?>';

<? include $css['sh-1']; ?>
<? include $css['sh-2']; ?>