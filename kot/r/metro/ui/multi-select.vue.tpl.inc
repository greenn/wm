<?
$Self = _kot::self();
$nMS = $Self::nc('multi-select');
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>
<div class="<?=$nMS?>">
    <? if (!1) {?><div>value: {{ value }}</div><? } ?>



    <div fxr fxi="b">
        <ui-select
            ref="select"
            :label="label"
            :options="options"
            :busy="busy"
            <?//:disabled="disabler"?>
            :checkbox="undefined"
            :clickUpdate="false"
            :relValid="valid"
            @update:value="addValue"
            <?//@update:value="$emit('update:value', $event)"?>
            @update:checkbox="$emit('update:checkbox', $event)"
        ></ui-select>
        <?/*<span class="<?=$nMS?>-note ft-small w-lgt">
            * Выбрать можно до 3-ёх станций
        </span>*/?>
    </div>

    <div class="<?=$nMS?>-values" fxr fxw>
        <span v-for="item in selection" class="<?=$nMS?>-value">
            <span>{{ item.title }}</span>
            <ui-button e-button title="Убрать значение" @click="removeValue(item.id)">
                <i class="material-icons cmd-back">cancel</i>
            </ui-button>
        </span>
    </div>

    <? if (1) { ?>

    <? } ?>
</div>