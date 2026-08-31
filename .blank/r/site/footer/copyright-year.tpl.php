<?
$Self = _site::self();
$nCt = $Self::nc('copyright');

$Self::req_css('footer');

//$_ctx = $Self::tempCtx(array());

$startYear = _pro('start-year');
$curYear = (integer) date('Y');

?>
<? if ($curYear != $startYear) { ?>
    <span class="<?=$nCt?>-year -start"><?=$startYear?></span>
    <span class="<?=$nCt?>-year -dash">-</span>
    <span class="<?=$nCt?>-year -cur"><?=$curYear?></span>
<? } else { ?>
    <span class="<?=$nCt?>-year -start -cur"><?=$startYear?></span>
<? } ?>
