<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue 3 v-model Example</title>
    <!-- Подключение Vue.js 3 -->
    <script src="https://unpkg.com/vue@3.2.31/dist/vue.global.js"></script>
</head>
<body>
<div id="app">

    <p>Заголовок: {{ fields.title }}</p>
    <p>Состояние: {{ fields.on }}</p>
    <ui-field v-model:modelValueInput="fields.title" v-model:modelValueCheckbox="fields.on" />
</div>

<script>
    const UiField = {
        template: `
        <div>
          <input :value="modelValueInput" @input="$emit('update:modelValueInput', $event.target.value)" />
          <input type="checkbox" :checked="modelValueCheckbox" @change="$emit('update:modelValueCheckbox', $event.target.checked)" />
        </div>
      `,
        props: ['modelValueInput', 'modelValueCheckbox'],
        emits: ['update:modelValueInput', 'update:modelValueCheckbox']
    };

    const app = Vue.createApp({
        components: {
            UiField
        },
        data() {
            return {
                fields: {
                    title: 'dddd',
                    on: true
                }
            };
        }
    });

    app.mount('#app');
</script>
</body>
</html>
