<?
$Self = _rb::self();

?>
<div id="app">
    <section>
        <div>
            searchText: {{ searchText }}
        </div>
    </section>
    <custom-input-a
        :model-value="searchText"
        @update:model-value="searchText = $event"
    ></custom-input-a>

    <custom-input-b v-model="searchText"></custom-input-b>
</div>


<script>

    const _App = Vue.createApp({
        data: function(){
            return {
                searchText: '-'
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        _App.mount('#app');
    });


</script>

<script type="text/x-template" id="custom-input-a">
    <input
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</script>

<script type="text/x-template" id="custom-input">
    <input v-model="value">
</script>

<script>
    _App.component('custom-input-a', {
        template: '#custom-input-a',
        props: ['modelValue'],
        emits: ['update:modelValue'],
    });


    _App.component('custom-input-b', {
        template: '#custom-input',
        props: ['modelValue'],
        emits: ['update:modelValue'],
        computed: {
            value: {
                get() {
                    return this.modelValue
                },
                set(value) {
                    this.$emit('update:modelValue', value)
                }
            }
        }
    })

</script>

<?//=_source::html_export(array('vue'))?>