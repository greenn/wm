<?
$Self = _rb::self();

?>
<div id="app">
    <custom-cmpt :size="1"></custom-cmpt>
    <br />
    <custom-cmpt :size="0"></custom-cmpt>
</div>


<script>

    const _App = Vue.createApp({
        data: function(){
            return {}
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        _App.mount('#app');
    });


</script>

<script type="text/x-template" id="custom-cmpt">
    <template v-if="size">
        size: {{ size }}
    </template>
    <template v-if="!size">
        !size: {{ size }}
    </template>
</script>

<script>
    _App.component('custom-cmpt', {
        template: '#custom-cmpt',
        props: ['size'],
    });
</script>

<?//=_source::html_export(array('vue'))?>