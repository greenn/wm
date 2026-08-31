<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Field Example</title>
</head>
<body>
<div id="app">
    <custom-field v-model="value" />
    <p>Value: {{ value }}</p>
</div>

<script src="https://unpkg.com/vue@3.2.6/dist/vue.global.js"></script>
<script>
    // Код компонента UiField
    const UiField = {
        template: `
        <input :value="value" @input="$emit('input', $event.target.value)" />
      `,
        props: {
            value: String
        }
    };

    // Код компонента CustomField
    const CustomField = {
        template: `
        <div>
          <ui-field :value="internalValue" @input="internalValue = $event" />
        </div>
      `,
        components: {
            UiField
        },
        props: {
            modelValue: String
        },
        data() {
            return {
                internalValue: this.modelValue
            };
        },
        watch: {
            modelValue(newVal) {
                this.internalValue = newVal;
            },
            internalValue(newVal) {
                this.$emit('update:modelValue', newVal);
            }
        }
    };

    const app = Vue.createApp({
        data() {
            return {
                value: ''
            };
        }
    });

    app.component('custom-field', CustomField);

    app.mount('#app');
</script>
</body>
</html>
