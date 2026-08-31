<?
$Self = _site::self();
$nCt = $Self::nc('copyright');

$Self::req_css('footer');

//$_ctx = $Self::tempCtx(array());

$startYear = _pro('start-year');
$curYear = (integer) date('Y');

?>
<div txc class="<?=$nCt?> -part1 ft-copyright">
    <span><?=_pro('company-name')?></span>,
	<?=site_tpl('footer', 'copyright-year')?>
    ©<?//&copy;?>
	<?=_pro('company-title')?>
</div>
<div txc class="<?=$nCt?> -part1 ft-copyright">
    <i><?=_pro('base-title')?></i>
</div>