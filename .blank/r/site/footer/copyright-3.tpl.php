<?
$Self = _site::self();
$nCt = $Self::nc('copyright');

$Self::req_css('footer');

//$_ctx = $Self::tempCtx(array());

$startYear = _pro('start-year');
$curYear = (integer) date('Y');

?>
<div txc class="<?=$nCt?> -part1 ft-copyright">
    <span><?=_pro('company-name')?></span>
    ©<?//&copy;?>
    <?=site_tpl('footer', 'copyright-year')?>,
    <span><?=_pro('base-title')?></span>
</div>
<div txc class="<?=$nCt?> -part1 ft-copyright">
    <span><?=_pro('company-title')?></span>
</div>