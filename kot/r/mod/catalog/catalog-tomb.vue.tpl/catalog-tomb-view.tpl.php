<?
$Self = _kmod::self();
$nTI = $Self::nc('TI'); //tombs-item
//$_ctx = $Self::tempCtx(array());
?>
<template v-if="ready">
    <div fxr>
        <div wp50 mr6>
            <div txc>{{ id }}</div>
            <div fxr="sb">
                <div>-nK-</div>
                <div>-A-</div>
                <div>-T-</div>
                <div>-3D-</div>
            </div>
        </div>
        <div wp50 mr6>
            -pic-
        </div>
    </div>
    <div osx h110>
        <div v-for="(price, index) in itemData.pricelist">
            {{ index + 1 }})
            {{ price.size }}
            ({{ Object.keys(price.prices).length }})
        </div>
    </div>
</template>
<template v-else>
    <div fxr>
        <div wp50 mr6>
            <div txc>{{ id }}</div>
        </div>
    </div>
    <div>- нет данных -</div>
</template>