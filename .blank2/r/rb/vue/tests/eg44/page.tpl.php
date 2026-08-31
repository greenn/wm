
<div id="app">
    <keep-alive>
        <component v-for="field in fields" v-bind:is="field.type" :key="field.id"></component>
    </keep-alive>

    <button type="button" v-on:click="addFormElement('form-input')">Add Textbox</button>
    <button type="button" v-on:click="addFormElement('form-select')">Add Select</button>
    <button type="button" v-on:click="addFormElement('form-textarea')">Add Textarea</button>
</div>

<script type="x-template" id="form-input">
    <div>
        <label>Text</label>
        <input type="text" />
    </div>
</script>

<script type="x-template" id="form-select">
    <div>
        <label>Select</label>
        <select>
            <option>Option 1</option>
            <option>Option 2</option>
        </select>
    </div>
</script>

<script type="x-template" id="form-textarea">
    <div>
        <label>Textarea</label>
        <textarea></textarea>
    </div>
</script>

<script>

    var App = Vue.createApp({
        data: function(){
            return {
                fields: [],
                count: 0
            }
        },

        methods: {
            addFormElement: function(type) {
                this.fields.push({
                    'type': type,
                    id: this.count++
                });
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        App.mount('#app');
    });



    App.component('form-input', {
        template: '#form-input'
    });

    App.component('form-select', {
        template: '#form-select'
    });

    App.component('form-textarea', {
        template: '#form-textarea'
    });



</script>