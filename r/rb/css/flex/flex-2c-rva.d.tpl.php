<?
$Self = _rb::self();
$Self::req_css('flex');
//$nn = $Self::nc('2cRva');

$_ctx = $Self::tempCtx(array(
	'nc' => '',
	'nc1' => '',
	'c1' => '',
	'nc2' => '',
	'c2' => '',
));
$nc = $_ctx['nc'];
$nc1 = $_ctx['nc1'];
$_c1 = $_ctx['c1'];
$nc2 = $_ctx['nc2'];
$_c2 = $_ctx['c2'];
?>
<div fx="c" class="<?=$nc?>">
    <div fxc left class="<?=$nc1?>">
        <span content="logo"><?=$_c1?></span>
    </div>
    <div fxc right="va" class="<?=$nc2?>">
        <span content="title"><?=$_c2?></span>
    </div>
</div>