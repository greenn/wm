<!DOCTYPE html>
<html lang="en">
<head>
	<title>App</title>
	<script src="https://unpkg.com/vue@next"></script>
</head>
<body>
<div id="app">
	<async-comp></async-comp>
</div>
<script>
    const app = Vue.createApp({});
    const AsyncComp = Vue.defineAsyncComponent(
        () =>
            new Promise((resolve, reject) => {
                resolve({
                    template: "<div>async component</div>"
                });
            })
    );
    app.component("async-comp", AsyncComp);
    app.mount("#app");
</script>
</body>
</html>