<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue Extending Component Example</title>
    <script src="https://unpkg.com/vue@3.2.31/dist/vue.global.js"></script>
</head>
<body>
<div id="app">
    <extended-field v-model:field-value="inputValue"></extended-field>
    <p>Field Value: {{ inputValue }}</p>
</div>

<script>
    const UiField = {
        props: ['modelValue'],
        emits: ['update:modelValue'],
        template: `
        <div>
          <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
        </div>
      `
    };

    const ExtendedField = {
        components: {
            UiField
        },
        props: ['fieldValue'],
        emits: ['update:fieldValue'],
        template: `
        <div>
          <ui-field v-model:model-value="localFieldValue"></ui-field>
        </div>
      `,
        data() {
            return {
                localFieldValue: this.fieldValue
            };
        },
        watch: {
            localFieldValue(newValue) {
                this.$emit('update:fieldValue', newValue);
            }
        }
    };

    const app = Vue.createApp({
        components: {
            ExtendedField
        },
        data() {
            return {
                inputValue: 'Initial Value'
            };
        }
    });

    app.mount('#app');
</script>
</body>
</html>
