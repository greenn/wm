<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

/*
    test/eg9/rndr/unpkg.com/vuetify@3.0.0-alpha.11/src/components/VApp/VApp.tsx
    test/eg9/rndr/unpkg.com/vuetify@3.0.0-alpha.11/src/components/VSheet/VSheet.tsx
*/
?>

<template>
    <p class="greeting">{{ greeting }}</p>
</template>

<script>
    export default {
        data: function data() {
            return {
                greeting: 'Привет всем!'
            };
        }
    }
</script>

<style>
    .greeting {
        color: red;
        font-weight: bold;
    }
</style>