<?
$Self = _rt::self();
$relDir = $Self::relDir();

$nM = $Self::nc('menu');

$Self::vue_req('v-menu', "$relDir/menu");

//https://v3.ru.vuejs.org/ru/guide/migration/v-model.html#%D1%81%D0%B8%D0%BD%D1%82%D0%B0%D0%BA%D1%81%D0%B8%D1%81-%D0%B2-2-x

?>
<section class="<?=$nM?>">
    <v-menu
        @new-route="routeCmptName = $event"
        v-model:route-name="routeCmptName"
        <? if (0) { ?>
            :route-name="routeCmptName"
            @update:route-name="routeCmptName = $event"
        <? } ?>
    ></v-menu>
</section>