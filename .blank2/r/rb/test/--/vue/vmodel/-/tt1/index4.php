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
    <parent-component></parent-component>
</div>

<script>
    // Компонент UiInput
    const UiInput = {
        template: `
        <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
      `,
        props: ['modelValue']
    };

    // Компонент ParentComponent
    const ParentComponent = {
        components: {
            UiInput
        },
        template: `
        <div>
          <ui-input v-model="fields.title"></ui-input>
          <button @click="updateTitle">Обновить title</button>
          <p>Значение title: {{ fields.title }}</p>
        </div>
      `,
        data() {
            return {
                fields: {
                    title: 'headline'
                }
            };
        },
        methods: {
            updateTitle() {
                this.fields.title = 'Новый заголовок';
            }
        }
    };

    // Создание Vue приложения
    const app = Vue.createApp({
        components: {
            ParentComponent
        }
    });

    app.mount('#app');
</script>
</body>
</html>