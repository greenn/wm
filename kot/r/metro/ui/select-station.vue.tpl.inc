<?
$Self = _kot::self();
$nSS = $Self::nc('select-station');
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>
<div class="<?=$nSS?>">
    <?//<pre>station: {{ station }}</pre>?>
    <div fxr fxi="b">
        <span label>Кол-во проходов</span>
        <ui-field class="-num"
            ref="passes"
            :value="passes"
            @update:value="$emit('update:passes', $event)"
        ></ui-field>

        <span label>на станции</span>
        <ui-select
            ref="station"
            :label="false"
            :options="relOptions ? options : selfOptions"
            :busy="busy"
            <?//v-model:value="station"?>
            :value="value" <?//bad @change="$emit('update:value', $event.target.value)"?>
            @update:value="$emit('update:value', $event)"
            :checkbox="undefined"
            :clickUpdate="false"
            <?//:relValid="valid"?>
        ></ui-select>

        <ui-button w-button title="Удалить из списка" @click="$emit('onRemove')">
            <i class="material-icons">remove</i>
            Удалить
        </ui-button>

        <ui-button v-if="addButton" r-button class="<?=$nSS?>-add"
            :disabled="addButtonDisabled"
            title="Добавить ещё станцию"
            @click="$emit('onAdd')"
        >
            <i class="material-icons">add</i>
            Добавить
        </ui-button>

    </div>
</div>