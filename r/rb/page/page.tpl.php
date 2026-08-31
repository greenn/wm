<?/*#2.2.820
        сборка html-страницы
            по входным параметрам:
*/
_needphp(
	'fq/attr.class'
);

$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
    'head_replace' => false,
    'head' => '',
    'body_replace' => false,
    'body' => '',

    'pageTitle' => (pageName ? pageName.' | ' : '').hostName,
    'favicon' => true,
    'isMobile' => true,
    'meta' => array(),
        'og' => false,
        'seo' => false,
        'canonical' => false,
    'manifest' => false,
    'viewport' => '',

    'nc' => '',
    'a_body' => '',

    'webkit' => false,
    'base-css' => true,
    'raw-source' => '',
    'raw-source2' => '',
    'sourceExport' => false,
));

$head = $_ctx['head'];
$head_replace = $_ctx['head_replace'];
if (is_string($head_replace)) $head = $head_replace;

$body = $_ctx['body'];
$body_replace = $_ctx['body_replace'];
if (is_string($body_replace)) $body = $body_replace;


$pageTitle = $_ctx['pageTitle'];
$favicon = $_ctx['favicon'];
$isMobile = $_ctx['isMobile'];
$head = $_ctx['head'];

$meta = $_ctx['meta'];
$og = $_ctx['og'];
$seo = $_ctx['seo'];
$canonical = $_ctx['canonical'];
if ($canonical) $meta['canonicalUrl'] = $canonical;
if ($og) $meta['og'] = $og;
if ($seo) $meta['seo'] = $seo;

$manifest = $_ctx['manifest'];
$viewport = $_ctx['viewport'];

$nc = $_ctx['nc'];
$a_class = attr::klass_($_ctx['nc']);
//dx($_ctx['a_body']);
$a_body = attr::asd($_ctx['a_body']); //eg: php/fq/attr.class.php:188
//dx($a_body, $_ctx['a_body']);

$Self::call("webkit/main", array(
    'req' => $_ctx['webkit'],
    //'wjs' => $_ctx['wjs']
));

//if ($_ctx['base-css']) $Self::req_css(-10, 'css/base');
if ($_ctx['base-css']) rb('css', 'req_css', -10, 'base');

?>
<!DOCTYPE HTML>
<html>
<? if ($head_replace) print $head; else { ?>
	<head>
		<title><?=$pageTitle?></title>

        <?= $Self::favicon($favicon)?>

		<? if ($isMobile) print $Self::tpl('head/is-mobile'); ?>

		<?=$Self::tpl('head/meta', $meta)?>

        <? if ($manifest) { ?>
            <link rel="manifest" href="<?=$manifest?>">
		<? } ?>

		<? if ($viewport) { ?>
            <meta name="viewport" content="<?=$viewport?>" />
		<? } ?>

        <?=prop($_ctx, 'hack-font', '')?>

        <?=join(newline2, (array)$_ctx['raw-source'])?>
        <?=_source::html_export($_ctx['sourceExport'])?>
		<?=join(newline2, (array)$_ctx['raw-source2'])?>

		<?=is_array($head) ? join(newline, $head) : $head?>
	</head>
<? } ?>
<? if ($body_replace) print $body; else { ?>
	<body <?=$a_class?> <?=$a_body?>>
        <?=$body?>
        <?//=$Self::tpl('body/notch-info')?>
	</body>
<? } ?>
</html>
