<?
$Self = _kot::self();
$nSS = $Self::nc('select-station');
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>
<div class="<?=$nSS?>">
    <? if (0) {?><div>value: {{ value }}</div><? } ?>
    <div fxr fxi="b">
        <ui-select
            ref="select"
            :label="label || 'На станции'"
            :options="options"
            :busy="busy"
            <?//:value="station"?>
            :disabled="disabler"
            :checkbox="undefined"
            :clickUpdate="false"
            :relValid="valid"
            <?/*
                @onFocus="multiple = 1"
                @onBlur="multiple = 0"
                :multiple="multiple"
            */?>
            <?//oo iq/test/js/vue/vmodel/tt6/index.php - off man?>
            @update:value="addValue"
            <?//@update:value="$emit('update:value', $event)"?>
            @update:checkbox="$emit('update:checkbox', $event)"
        ></ui-select>
        <?/*<span class="<?=$nSS?>-note ft-small w-lgt">
            * Выбрать можно до 3-ёх станций
        </span>*/?>
    </div>

    <div class="<?=$nSS?>-values" fxr fxw>
        <span v-for="station in selection" class="<?=$nSS?>-value">
            <span>{{ station.title }}</span>
            <ui-button e-button title="Убрать выбранную станцию" @click="removeValue(station.id)">
                <i class="material-icons cmd-back">cancel</i>
            </ui-button>
        </span>
    </div>
</div>