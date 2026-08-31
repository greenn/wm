<?
$Self = _kot::self();
$nRV = $Self::nc('rview');
$Self::req_css('admin-r');
//$Self::req_css('rview');

_kot::req_vue('ui', 'button', array(), 'ui-button');

$Self::req_vue('r-view');
//$Self::req_vue('r-view', array(), 'blank-item');
?>
<div class="<?=$nRV?>">
    <? if (!1) { ?>
        <pre no>prm: {{ prm }}</pre>
        <pre no>opt: {{ opt }}</pre>
	<? } ?>

    <?=kot_tpl('ui', 'provide/opt-fields', array(
        //'nc' => "$nM-opt"
    ))?>


    <r-view name="set.kmod"></r-view>

	<?=kot_tpl('ui', 'provide/set-fields', array(
		//'nc' => "$nM-set"
	))?>

    <div r fxr="c" class="<?=$nM?>-cmd" mb10>

        <span <?//fg txc?>>
            <ui-button bu-button @click="submitCreate">
                create
            </ui-button>
        </span>


    </div>
</div>