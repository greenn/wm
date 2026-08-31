<?
$Self = _kot::self();
$nSS = $Self::nc('select-station');
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>
<div class="<?=$nSS?>">
    <?//<pre>station: {{ station }}</pre>?>
    <div fxr fxi="b">
        <span label>Проходы</span><?//Кол-во проходов?>
        <ui-field class="-num2"
            ref="num"
            :value="passes"
            @update:value="$emit('update:passes', $event)"
        ></ui-field>

        <span label>транспорт</span><?//Вид транспорта?>
        <ui-select
            ref="value_type"
            :label="false"
            :options="typeOptions"
            :busy="busy"
            :value="type"
            @update:value="$emit('update:type', $event)"
            :checkbox="undefined"
            :clickUpdate="false"
        ></ui-select>

        <span label>маршрут</span><?//Номер маршрута?>
        <ui-select
            ref="id"
            :label="false"
            :options="options"
            :busy="busy"
            :value="id"
            @update:value="$emit('update:id', $event)"
            :checkbox="undefined"
            :clickUpdate="false"
            :disabled="!type"
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