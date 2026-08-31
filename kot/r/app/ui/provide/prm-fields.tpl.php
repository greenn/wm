<?
$Self = _kot::self();
$_ctx = $Self::tempCtx(array(
	//'baseUri' => '',
));
//$baseUri = $_ctx['baseUri'];

?>
<? if (1) { ?>
    <pre no>prm: {{ prm }}</pre>
<? } ?>
<div fxr fxw mb7>

    <ui-button mr2 small b-button @click="prmDeleteLast">
        <icon-mi>delete</icon-mi>
    </ui-button>

    <ui-button mr2 small b-button @click="prmAdd">
        <icon-mi>add</icon-mi>
    </ui-button>
    <span mr3></span>

    <div fxr wp28 mr10 v-for="p in prm">
        <input type="checkbox" v-model="p.use"  />
        <label wp40><input p0 wp100 v-model="p.name" /></label>
        <span>:</span>
        <div wp60 mr2><input p0 wp100 v-model="p.value" /></div>
        <ui-button no ml5 mr6 small s-button title="запомнить" @click="false">
            <icon-m>keep</icon-m>
        </ui-button>
    </div>

</div>