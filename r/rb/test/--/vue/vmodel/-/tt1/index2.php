<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPT Vue2 example</title>
    <!-- Подключение Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
</head>
<body>
<div id="app">
    <parent-component></parent-component>
</div>

<script>
    // Компонент UiInput
    Vue.component('ui-input', {
        template: `
        <input :value="value" @input="$emit('input', $event.target.value)" />
      `,
        props: ['value']
    });

    // Компонент ParentComponent
    Vue.component('parent-component', {
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
    });

    // Создание Vue приложения
    new Vue({
        el: '#app'
    });
</script>
</body>
</html>
