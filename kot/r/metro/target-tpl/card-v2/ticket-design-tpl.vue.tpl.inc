<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nCTD = $Self::nc('C-TD'); //tpl-card--ticket-design
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nCTD?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

	<? if (1) { ?>
        <multi-select
            :ref="el => addValidate(el, 'select')"
            :label="'Тип'"
            v-model:options="options"
            :info="optionsInfo"
            :busy="busy"
            v-model:value="cfg['list']"
        ></multi-select>
	<? } ?>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>