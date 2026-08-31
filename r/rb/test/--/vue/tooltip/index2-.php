<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Vue Material Tooltip Example</title>
	<link rel="stylesheet" href="https://unpkg.com/vue-material@1.0.0-beta-12/dist/vue-material.min.css">
	<script src="https://unpkg.com/vue@3.2.20/dist/vue.global.js"></script>
	<script src="https://unpkg.com/vue-material@1.0.0-beta-16/dist/vue-material.min.js"></script>
</head>
<body>
<div id="app">
	<md-tooltip md-direction="bottom" md-delay="1000">
		Tooltip Text
	</md-tooltip>

	<button @mouseover="showTooltip = true" @mouseleave="showTooltip = false">
		Hover Me
	</button>

	<md-tooltip :md-show="showTooltip" md-direction="top">
		Tooltip on Button
	</md-tooltip>
</div>

<script>
    Vue.createApp({
        data() {
            return {
                showTooltip: false,
            };
        },
    }).mount('#app');
</script>
</body>
</html>
