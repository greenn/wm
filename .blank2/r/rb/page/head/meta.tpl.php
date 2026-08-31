<?
    //$parentRpName = basename(dirname(dirname(__FILE__)));

    $Self = _rb::self();

    $_ctx = $Self::tempCtx(array(
	    'canonicalUrl' => false,
	    'seo' => false,
	    'og' => false,
	    'content' => '',
    )); //dx($_ctx);

    $canonicalUrl = $_ctx['canonicalUrl'];
    $seo = $_ctx['seo'];
    $og = $_ctx['og'];
    $content = $_ctx['content'];

    //dx($og);

    //dx($seo, $og);

    //hk-klimenko //if ($canonicalUrl === '/'.site_opt('rootPageName')) $canonicalUrl = '/';
?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<?=$Self::tpl('head/meta-mobile', array())?>

<? if ($canonicalUrl) { ?><link rel="canonical" href="<?=$canonicalUrl?>" /><? } ?>

<? if (is_array($seo)) { print $Self::tpl('head/meta-seo', $seo); } ?>

<? if (is_array($og)) { print $Self::tpl('head/meta-og', $og); } ?>

<? /* if (x('GoogleFontsPreconnect')){ ?>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<? }*/ ?>
<?=$content?>