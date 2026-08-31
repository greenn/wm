<?
$Self = _kot::self();
$Self::req_css('target-tpl');

$nT2 = $Self::nc('T2');
$nPlT = $Self::nc('Pl-T'); //tpl-place--transport

$Self::req_vue('tpl2/tpl2-list', array(), 'tpl2-list');
?>
<section class="<?=$nT2?> -pt <?=$nPlT?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-list
        :label="'Точки продажи выбранного перевозчика:'"
        :list="cfg['list']"
        :info="info"
        :busy="busy"
    ></tpl2-list>

	<? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>
	<? if (!1) { ?><pre>info: {{ info }}</pre><? } ?>
</section>