<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPB = $Self::nc('P-B'); //tpl-passenger--bio
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
$Self::req_vue('select', array(), 'ui-select');
?>

<section tw class="<?=$nT?> <?=$nPB?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <ui-select
        :ref="el => addValidate(el, 'value')"
        :label="'Пол'"
        :options="options"
        :busy="busy"
        :hideBusy="true"
        v-model:value="cfg['value']"
	    <?//:value="cfg['value']" @update:value="$emit('update:value', $event)"?>
    ></ui-select>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>