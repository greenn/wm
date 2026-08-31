<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bad Vue v-model Example</title>
    <script src="https://unpkg.com/vue@3.2.31/dist/vue.global.js"></script>
</head>
<body>
<div id="app">
    <custom-checkbox v-model:checked="isChecked"></custom-checkbox>
    <p>Is Checked: {{ isChecked }}</p>
</div>

<script>
    // Дочерний компонент CustomCheckbox.vue
    const CustomCheckbox = {
        props: ['modelValue'],
        emits: ['update:modelValue'],
        template: `
        <div>
          <input type="checkbox" :checked="modelValue" @change="$emit('update:modelValue', $event.target.checked)" />
        </div>
      `
    }

    // Родительский компонент
    const app = Vue.createApp({
        components: {
            CustomCheckbox
        },
        data() {
            return {
                isChecked: false
            }
        }
    });

    app.mount('#app');
</script>
</body>
</html>
