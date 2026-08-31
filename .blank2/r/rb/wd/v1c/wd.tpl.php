<?#3.1.0
//oo rb/wd-/v6/wd.tpl.php


$Self = _rb::self();
$vn = $Self::relDir(); //vn - version name | dn - directory name
$n = $Self::nc($vn);
//dx($n); //bWD-v1c
//dx($vn); //v1c

//_rb::req_css(-1, 'page', 'css/q');
$Self::req_css("$vn/wd");
$Self::req_js("$vn/wd");

$_ctx = $Self::tempCtx(array(
	'embody' => false,
	'img' => false,
	'id' => false,
	'cmdPos' => false,
	'css-fix' => false,
	'embody-fix' => false,
));
//dx($_ctx);



$cssFix = $_ctx['css-fix'];
$embodyFix = $_ctx['embody-fix'];

$_embody = $_ctx['embody'];

$id = $_ctx['id'];
$img = $_ctx['img'];
$src = "wd/$img";

if (!$id) $id = $Self::take_id($src);
$id .= "-$vn";

if (preg_match('/^\d/', $id)) {
	$id = '_'.$id;
}


ob_start(); ?>
    $(function(){
        setTimeout(function(){
            WD_<?=$vn?>({
                id: '<?=$id?>',
                <? if ($_ctx['cmdPos']) { ?>
                    ncPos: '-<?=$_ctx['cmdPos']?>',
                <? } ?>
            });
        }, 0)
    })
<? $jsInline = ob_get_clean();
js::req(10, false, false, $jsInline);


$_i = pro_opt_env('i'); //i()
//if (_x('hkIqWdImgClass')) $_i = _x('hkIqWdImgClass');
//$_i = cur_or('iClass', '_i');

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
<style>
	<?=rb_wd::css_v1c($n, $id, $imgData)?>
    <? if (0 && 'eg') { ?>
        #footer-m-v1c {
            width: 430px;
            height: 139px;
        }

        #footer-m-v1c > .bWD-v1c-view > .bWD-v1c-src {
            background-image: url('/gss3/i/wd/footer.m.png');

        }

        #footer-m-v1c .bWD-v1c-view {
            width: 430px;
            height: 139px;

        }

        #footer-m-v1c > .bWD-v1c-view > .bWD-v1c-src {
            background-image: url('/gss3/i/wd/footer.m.png');

        }
    <? } ?>

    <? if ($cssFix) { ?>
        #<?=$id?> { <?=$cssFix?> }
    <? } ?>
    <? if ($embodyFix) { ?>
        #<?=$id?> > .<?=$n?>-embody { <?=$embodyFix?> }
    <? } ?>
</style>