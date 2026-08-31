<?

$Self = _rb::self();
$n = $Self::nc();
$_ctx = $Self::tempCtx(array(
	'indent-top' => false,
	'indent-bootom' => false,
	'lay' => false,
	'nc' => '',
));

$nc = $_ctx['nc'];

$indentTop = $_ctx['indent-top'];
$indentBottom = $_ctx['indent-bottom'];

//_site::req_css('ui', 'css/ft');
//$Self::req_css('header');
//$Self::req_js('header');

//d($Self::_cfg(), $Self::cfg('className'), $Self::cfg('rName'));
?>

<div class="<?=$nc?> <?=$ncClose?>">
	<div indent="<?=$n?>-top"></div>
	<div tc>v1</div>
	<div indent="<?=$n?>-bottom"></div>
</div>