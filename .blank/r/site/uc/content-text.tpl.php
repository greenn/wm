<?
$Self = _site::self();
$nC = $Self::nc('content');

$Self::req_css('uc');
//$Self::req_js('blank');

$_ctx = $Self::tempCtx(array(
	'h2' => 'Страница скоро будет доступна!',
	'text' => 'Уважаемые посетители, на данный момент страница находится в стадии разработки. Мы активно работаем над тем, чтобы предоставить вам качественный и полезный контент. Приносим извинения за временные неудобства и благодарим за терпение. Пожалуйста, проверяйте обновления - наша команда делает все возможное, чтобы страница была доступна в ближайшее время. Спасибо за ваше понимание и поддержку!',
	'before' => '',
	'after' => _i::img('uc/pics/full/ucc-pic-5.t.png', "tc h400 pt10 class==\"$nC-pic\"", '-height: 400px'),
));

$h2 = $_ctx['h2'];

$text = $_ctx['text'];
//$pic1 = $_ctx['pic-before'];
//$pic2 = $_ctx['pic-after'];

$before = $_ctx['before'];
$after = $_ctx['after'];

$_text = $text;
?>

<div class="<?=$nC?>">
	<div indent="<?=$nC?>-start"></div>
	<? if ($before) { ?>
		<?=$before?>
		<div indent="<?=$nC?>-before"></div>
	<? } ?>

	<? if ($h2) { ?>
		<h2 tc pb30><?=$h2?></h2>
	<? } ?>

	<?=$_text?>

	<? if ($after) { ?>
		<div indent="<?=$nC?>-after"></div>
		<?=$after?>
	<? } ?>
	<div indent="<?=$nC?>-end"></div>
</div>