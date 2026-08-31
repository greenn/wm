<?
$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'img' => 'def',
));

$img = $_ctx['img'];

$ni = "wd/$img";
$s = _i::size($ni);
$i = _i::uri($ni);
//dx($i, $s);
?>
<div style="<?=join('; ', array(
	"width: {$s['w']}px",
	"height: {$s['h']}px",
	"background: url('$i') no-repeat left top",
))?>"></div>
