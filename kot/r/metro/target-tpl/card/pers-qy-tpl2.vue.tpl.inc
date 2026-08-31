<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nCPQ = $Self::nc('C-PQ'); //tpl-card--pers-qy
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-field', array(), 'tpl2-field');
?>
<section class="<?=$nT2?> -pt <?=$nCPQ?>">
	<?=$Self::tpl('vue-tpl2-forecast')?>

    <div fxr fxi="b">
        <?//<span class="-pr">Количество носителей:</span>?>

        <tpl2-field
            :label="'От'"
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