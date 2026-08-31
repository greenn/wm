<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nTS = $Self::nc('T-S'); //tpl-topup--sum
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-field', array(), 'tpl2-field');
?>
<section class="<?=$nT2?> -pt <?=$nTS?>">
	<?=$Self::tpl('vue-tpl2-forecast')?>

    <div fxr fxi="b">
        <span class="-pr">Кошелек на сумму:</span>

        <tpl2-field
            :label="'от'"
            :value="cfg['numFrom']"
            :valueFix="true"
            :nc="'-num2'"
        ></tpl2-field>

        <span class="<?=$nT2?>-sep"></span>

        <tpl2-field
            :label="'до'"
            :value="cfg['numTo']"
            :valueFix="true"
            :nc="'-num2'"
        ></tpl2-field>
    </div>

</section>