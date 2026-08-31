<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vue 3 CDN Example with :ref</title>
    <script src="https://unpkg.com/vue@next"></script>
</head>
<body>

<div id="app">
    <button @click="callChildrenMethods">Call Validate on All Children</button>
    <child-component :ref="function(el) { if(el) addChild(el, 'field-type') }"></child-component>
    <div v-for="(item, index) in items" :key="index">
        <child-component :ref="function(el) { if(el) addChild(el, 'field-type') }"></child-component>
    </div>
</div>

<script>
    const ChildComponent = {
        template: '<div>I am a child</div>',
        mounted() {
            console.log('Child mounted');
        },
        methods: {
            validate() {
                console.log('Validating the child component');
            }
        }
    };

    const app = Vue.createApp({
        data() {
            return {
                items: [1, 2, 3],  // Dummy array to create multiple child components
                childComponents: []
            };
        },
        methods: {
            addChild(el, type) {
                console.log('Adding child', el, type);
                this.childComponents.push({ el, type });

            },
            callChildrenMethods() {
                this.childComponents.forEach(child => {
                    child.el.validate();
                });
            }
        },
        components: {
            'child-component': ChildComponent
        },
        mounted(){
            console.log('mounted', { childComponents: this.childComponents })
        }
    });

    app.mount('#app');
</script>

</body>
</html>
