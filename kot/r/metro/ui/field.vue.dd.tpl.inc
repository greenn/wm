0813 vue input-checkbox egx

Обратите внимание на использование синтаксиса .sync, который позволяет обновлять значения внутри компонента UiField из родительского компонента с помощью событий inputChange и checkboxChange.


<template>
    <div>
        <!-- Input element -->
        <input :value="inputValue" @input="updateInputValue" />

        <!-- Checkbox element -->
        <input type="checkbox" :checked="checkboxValue" @change="updateCheckboxValue" />
    </div>
</template>

<script>
    export default {
        props: {
            inputValue: String,   // Пропс для значения input
            checkboxValue: Boolean  // Пропс для значения checkbox
        },
        methods: {
            updateInputValue(event) {
                // Генерируем событие inputChange при изменении значения input
                this.$emit('inputChange', 'inputValue', event.target.value);
            },
            updateCheckboxValue(event) {
                // Генерируем событие checkboxChange при изменении значения checkbox
                this.$emit('checkboxChange', 'checkboxValue', event.target.checked);
            }
        }
    };
</script>


-	-	-	-

<template>
    <div>
        <ui-field :input-value.sync="inputValue" :checkbox-value.sync="checkboxValue" />
    </div>
</template>

<script>
    import UiField from './UiField.vue';

    export default {
        components: {
            UiField
        },
        data() {
            return {
                inputValue: '',
                checkboxValue: false
            };
        }
    };
</script>

-   -   -   -

<ui-select v-model:model-selected="fields.gender" :options-data="['male', 'female']"></ui-select>

<select :value="modelValueSelected" @change="$emit('update:modelSelected', $event.target.value)">
    <option v-for="option in optionsData" :value="option">{{ option }}</option>
</select>
