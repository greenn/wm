<?#5.1.15
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//_needphp('headers', 'img/i_');

$Self = _site::self();
///$n_PT = site('page', 'nc', 'text');

$f0 = _css('f0');
$f1 = _css('f1');
$fs0 = _css('fs_', 't', 1);

//if(0) //dbg
$css = array();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    $css['ft/ftq'] = $Self::path('ft/ftq.css.inc'),
    $css['ft/fs'] = $Self::path('ft/fs.css.inc'),
    $css['ft/font-weight'] = $Self::path('ft/font-weight.css.inc'),
    $css['ft/colors'] = $Self::path('ft/colors.css.inc'),
    $css['ft/ffs'] = $Self::path('ft/colors.css.inc'),
    __FILE__
));

?>
HTML {
	font-family: <?=$f1?>, <?=$f0?>;
	font-size: <?=$fs0?>px;
	color: <?=_css('tc-base')?>;
}

A {
    cursor: pointer;
    text-decoration: underline;
    color: <?=_css('tc-base')?>;
}
A:hover {}
A[nolink] { cursor: default; }
A[nolink][cp] { cursor: pointer; }


*[class*="ft-"] .-uc,
*[class*="ft-"].-uc {
    text-transform: uppercase;
}
*[class*="ft-"] .-lc,
*[class*="ft-"].-lc {
    text-transform: lowercase;
}

[fsi] {
    font-style: italic;
}

<? include $css['ft/ftq']; ?>

<? include $css['ft/fs']; ?>

<? include $css['ft/font-weight']; ?>

<? include $css['ft/colors']; ?>

<? include $css['ft/ffs']; ?>