<?
//oo rb/wd-/v6/wd.tpl.php


$Self = _rb::self();
$vn = $Self::relDir(); //vn - verion name | dn - directory name
$n = $Self::nc($vn);

//_rb::req_css(-1, 'page', 'css/q');
$Self::req_css("$vn/wd");
$Self::req_js("$vn/wd");

$_ctx = $Self::tempCtx(array(
	'embody' => false,
	'img' => false,
	'id' => false,
	'cmdPos' => false,
));
//dx($_ctx);
$_embody = $_ctx['embody'];

$id = $_ctx['id'];
$img = $_ctx['img'];
$src = "wd/$img";

if (!$id) $id = $Self::take_id($src);
$id .= "-$vn";

$imgData = _i::size($src);
$imgData['src'] = _i::uri($src);
//dx($_ctx, $imgData, $id);

?>
<div wd="<?=$id?>" b r class="<?=$n?>">
	<div class="oh <?=$n?>-view">
		<div class="<?=$n?>-src"></div>
	</div>
	<? if ($_embody) { ?>
		<div class="<?=$n?>-embody"><?=$_embody?></div>
	<? } ?>
</div>
<style type="text/css">
	<?=$Self::cssRule("[wd=\"$id\"]", array(
        'width' => $imgData['w'].'px',
		'height' => $imgData['h'].'px',
	))?>
    <?=$Self::cssRule("[wd=\"$id\"] > .$n-view > .$n-src", array(
        'background-image' => "url('{$imgData['src']}')",
	))?>
</style>
<script type="text/javascript" async>
    WD_<?=$vn?>({
        id: '<?=$id?>',
        $par: $('[wd="<?=$id?>"]'),
	    <? if ($_ctx['cmdPos']) { ?>ncPos: '-<?=$_ctx['cmdPos']?>',<? } ?>
    });
</script>