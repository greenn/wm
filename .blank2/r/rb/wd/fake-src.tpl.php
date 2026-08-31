<?//реплика fake.tpl для сторонних картинок
$Self = _rb::self();
$nF = $Self::nc('fake');

$Self::req_css("fake");
//_rb::req_css('page', 'css/aq');

$_ctx = $Self::tempCtx(array(
	'src' => false,
	'host' => '',
));
$src = $_ctx['src'];
$host = $_ctx['host'];
$path = ROOT.$src;

$data = getimagesize($path);
$w = $data[0];

?>
<div <?//=$aq?> class="<?=$nF?>">
    <img src="<?=($host ? "$host/" : '').$src?>" style="max-width: <?=$w?>px;"/>
</div>