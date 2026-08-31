<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

/*
    test/eg9/rndr/unpkg.com/vuetify@3.0.0-alpha.11/src/components/VApp/VApp.tsx
    test/eg9/rndr/unpkg.com/vuetify@3.0.0-alpha.11/src/components/VSheet/VSheet.tsx
*/
?>

<script type="text/x-template" id="app-template">
    <v-app>
        <div class="text-center">
            <v-slider
                    v-model="model"
                    :max="rounded.length - 1"
                    :tick-labels="rounded"
            ></v-slider>

            <div class="py-3"></div>

            <v-sheet
                    :class="radius"
                    :max-width="model === 6 ? 128 : 256"
                    class="mx-auto transition-swing secondary"
                    elevation="12"
                    height="128"
                    width="100%"
            ></v-sheet>

            <div class="py-3"></div>

            <code class="text-subtitle-1">.{{ radius }}</code>
        </div>
    </v-app>
</script>

<div id="app"></div>