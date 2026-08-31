<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nCCS = $Self::nc('C-CS'); //tpl-card--card-status
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nCCS?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <ui-busy v-if="busy" :visible="true"></ui-busy>
    <template v-else>
        <span class="-pr">Выбранный статус:</span>
        <span>{{ title }}</span>
    </template>

</section>