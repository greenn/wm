<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

/*
    test/eg9/rndr/unpkg.com/vuetify@3.0.0-alpha.11/src/components/VApp/VApp.tsx
    test/eg9/rndr/unpkg.com/vuetify@3.0.0-alpha.11/src/components/VSheet/VSheet.tsx
*/
?>

<script type="text/x-template" id="app-template"></script>
<script type="text/x-template" id="alert-box">
    <div class="demo-alert-box">
        <strong>Error!</strong>
        <slot></slot>
    </div>
</script>

<div id="app">

    <alert-box>
        Произошло что-то плохое.
    </alert-box>

</div>


