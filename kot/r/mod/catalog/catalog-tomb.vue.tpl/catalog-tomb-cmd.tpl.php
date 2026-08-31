<?
$Self = _kmod::self();
$nTI = $Self::nc('TI'); //tombs-item
//$_ctx = $Self::tempCtx(array());
?>
<div txc>{{ id }}</div>
<div fxr="c" fxi="с">

    <div>
        <ui-button small b-button @click="n.add()">
            Обновить
        </ui-button>
        <? if (0) { ?>
            <ui-button small b-button @click="toggleValue('loadingData')">
                ak loading
            </ui-button>
		<? } ?>

    </div>

</div>