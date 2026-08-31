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
	'css-fix' => false,
));
//dx($_ctx);

$cssFix = $_ctx['css-fix'];

$_embody = $_ctx['embody'];

$id = $_ctx['id'];
$img = $_ctx['img'];
$src = "wd/$img";

if (!$id) $id = $Self::take_id($src);
$id .= "-$vn";

if (preg_match('/^\d/', $id)) {
	$id = '_'.$id;
}

$_i = pro_opt_env('i'); //i()

$imgData = $_i::size($src);
$imgData['src'] = $_i::uri($src);
//dx($_ctx, $imgData, $id);

?>
<div wd id="<?=$id?>" class="<?=$n?>">
	<div class="oh <?=$n?>-view">
		<div class="<?=$n?>-src"></div>
	</div>
	<? if ($_embody) { ?>
		<div class="<?=$n?>-embody"><?=$_embody?></div>
	<? } ?>
</div>
<style type="text/css">
	<?=rb_wd::css_v1($n, $id, $imgData)?>
    <? if ($cssFix) { ?>
        #<?=$id?> { <?=$cssFix?> }
    <? } ?>
</style>
<? if (0) { ?>
<script type="text/javascript" async>
    WD_<?=$vn?>({
        id: '<?=$id?>',
	    <? if ($_ctx['cmdPos']) { ?>ncPos: '-<?=$_ctx['cmdPos']?>',<? } ?>
    });
</script>
<? } ?>
<? ob_start(); ?>
$(function(){
    //setTimeout(function(){
        WD_<?=$vn?>({
            id: '<?=$id?>',
            <? if ($_ctx['cmdPos']) { ?>ncPos: '-<?=$_ctx['cmdPos']?>',<? } ?>
        });
    //}, 0)
})
<? js::req(10, false, false, ob_get_clean()); ?>