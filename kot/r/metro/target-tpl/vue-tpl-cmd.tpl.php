<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$Self::req_css('target-tpl');

$_ctx = $Self::tempCtx(array(
    //'nc' => $Self::nc('tpl') //$nT
));
//$nc = $_ctx['nc'];
?>

<div class="<?=$nT?>-cmd">
    <? if (0) { ?>
        <div>
            Прогноз охвата: 10
        </div>
        <ui-button r-button @click="calcForecast">
            <i class="material-icons -mr">bar_chart</i><?//cancel?>
            Пересчитать
        </ui-button>
    <? } ?>

    <ui-button w-button @click="$emit('onRemove')">
        <i class="material-icons -mr">cancel</i><?//cancel?>
        Удалить
    </ui-button>



</div>
