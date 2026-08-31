<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Multiple Select Example</title>
</head>
<body>
<div id="app">
	<select v-model="selectedOptions" multiple>
		<option v-for="option in options" :key="option.value" :value="option.value">{{ option.label }}</option>
	</select>
	<p>Выбранные опции: {{ selectedOptions }}</p>
</div>

<script src="https://unpkg.com/vue@3.2.20/dist/vue.global.js"></script>
<script>
    const app = Vue.createApp({
        data() {
            return {
                selectedOptions: [],
                options: [
                    { value: 'option1', label: 'Опция 1' },
                    { value: 'option2', label: 'Опция 2' },
                    { value: 'option3', label: 'Опция 3' },
                ],
            };
        },
    });

    app.mount('#app');
</script>
</body>
</html>