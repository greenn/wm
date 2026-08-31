<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nCPE = $Self::nc('C-PE'); //tpl-card--pers-exist
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-checkbox', array(), 'tpl2-checkbox');
?>
<section class="<?=$nT2?> -pt <?=$nCPE?>">
	<?=$Self::tpl('vue-tpl2-forecast')?>

    <div>
        <span class="-pr">{{ cfg['flag'] ? 'Есть как минимум 1 носитель' : 'Ни один носитель не привязан' }}</span>

        <? if (0) { ?>
            <tpl2-checkbox
                :label="'Привязан'"
                :value="cfg['flag']"
                <?//:nc="'-num2'"?>
            ></tpl2-checkbox>
        <? } ?>
    </div>

</section>