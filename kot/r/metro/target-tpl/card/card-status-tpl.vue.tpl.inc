<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nCCS = $Self::nc('C-CS'); //tpl-card--card-status
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nCCS?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <ui-select
        :ref="el => addValidate(el, 'value')"
        :label="'Статус носителя'"
        :options="options"
        :busy="busy"
        :hideBusy="true"
        v-model:value="cfg['value']"
		<?//:value="cfg['value']" @update:value="$emit('update:value', $event)"?>
    ></ui-select>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>