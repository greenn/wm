<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nPB = $Self::nc('P-B'); //tpl-passenger--bio
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nPB?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <ui-busy v-if="busy" :visible="true"></ui-busy>
    <template v-else>
        <span class="-pr">Пол:</span>
        <span>{{ title }}</span>
    </template>

</section>