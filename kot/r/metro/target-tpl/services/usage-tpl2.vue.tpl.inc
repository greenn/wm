<?
$Self = _kot::self();
$Self::req_css('target-tpl');

$nT2 = $Self::nc('T2');
$nSeU = $Self::nc('Se-U'); //tpl-services--usage

$Self::req_vue('tpl2/tpl2-list', array(), 'tpl2-list');
?>
<section class="<?=$nT2?> -pt <?=$nSeU?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-list
        :label="'Выбранные сервисы:'"
        :list="cfg['list']"
        :info="info"
        :busy="busy"
    ></tpl2-list>

    <tpl2-interval
            :value="cfg['interval']"
		<?//:from="cfg['from']"?>
		<?//:to="cfg['to']"?>
    ></tpl2-interval>

	<? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>
	<? if (!1) { ?><pre>info: {{ info }}</pre><? } ?>
</section>