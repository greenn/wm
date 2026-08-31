<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-Tip Tooltip Example</title>
    <script src="https://unpkg.com/vue@3.2.20/dist/vue.global.js"></script>
    <script src="https://unpkg.com/v-tooltip@2.1.3/dist/v-tooltip.min.js"></script>
    <style>
        #app {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        button {
            padding: 10px 20px;
            border: none;
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="app">
    <button v-vtippy="'Tooltip on Button'">
        Hover Me
    </button>
</div>

<script>
    const app = Vue.createApp({
        setup() {
            // Use the v-tooltip plugin
            return { vtippy: window.vtippy };
        },
    });

    app.mount('#app');
</script>
</body>
</html>