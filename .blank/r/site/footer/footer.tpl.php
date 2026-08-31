<?
$Self = _site::self();
$n = $Self::nc();
$nCt = $Self::nc('copyright');

$Self::req_css('footer');

//$_ctx = $Self::tempCtx(array());

$startYear = _pro('start-year');
$curYear = (integer) date('Y');

?>

<div class="<?=$n?>">

	<?//=site_tpl('footer', 'copyright')?>
	<?=site_tpl('footer', 'copyright-3')?>
	<?//=site_tpl('footer', 'copyright-2')?>

</div>

<? if (0) { ?>
    <span>•</span>
<? } ?>