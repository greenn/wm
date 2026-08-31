<?
$Self = _kot::self();
$nFF = $Self::nc('forecast-field');
$Self::req_css('form');
$Self::req_vue('ui', 'no-field');
?>

<div fxr fxi="b" class="<?=$nFF?>">
    <div class="<?=$nFF?>-button">
        <ui-button r-button class="" @click="$emit('onCalc')" :disabled="disabled">
            <i class="material-icons">bar_chart</i>
            <span>Пересчитать</span>
        </ui-button>
    </div>
    <no-field
        class="<?=$nFF?>-info"
        :label="label || 'Охват'"
        :value="value" :nc-value="'ft-text w-bld -red'"
        :busy="busy"
    ></no-field>
</div>