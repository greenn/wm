<?
$Self = _rb::self();
$nF = $Self::nc('fake');

$Self::req_css("fake");
_rb::req_css('css', 'aq');

$_ctx = $Self::tempCtx(array(
	'img' => false,
	'aq' => '',
));
$img = $_ctx['img'];
$src = "wd/$img";



$aq = $_ctx['aq'];

$_i = pro_opt_env('i'); //i()
//if (_x('hkIqWdImgClass')) $_i = _x('hkIqWdImgClass');

$imgData = $_i::size($src);
//dx($src,  $_i::uri($src));

$imgData['src'] = $_i::uri($src);
//dx($imgData);
?>
<?if(!1){ ?><div><?=basename($img, '.' . pathinfo($img, PATHINFO_EXTENSION))?></div><? } ?>
<div <?=$aq?> class="<?=$nF?>" nos>
    <img src="<?=$imgData['src']?>" style="max-width: <?=$imgData['w']?>px;"/>
</div>