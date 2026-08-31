<?
$Self = _site::self();
$nCt = $Self::nc('copyright');

$_ctx = $Self::tempCtx(array(
    'startYear' => _pro('start-year')
));

$startYear = $_ctx['startYear'];
$curYear = (integer) date('Y');


?>
<?//=site_tpl('css', 'editor');?>
<div class="<?=$nCt?>">
    <span class="ft-small">
        ©<?//&copy;?>
        <span>GETTBOT</span>,
        <? if ($curYear != $startYear) { ?>
            <span class="<?=$nCt?>-year -start"><?=$startYear?></span>
            <span class="<?=$nCt?>-year -dash">-</span>
            <span class="<?=$nCt?>-year -cur"><?=$curYear?></span>
        <? } else { ?>
            <span class="<?=$nCt?>-year -start -cur"><?=$startYear?></span>
        <? } ?>
    </span>
</div>