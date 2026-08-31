<?
$Self = _kmod::self();
$nTIF = $Self::nc('TIF'); //tombs-item-filter
//$_ctx = $Self::tempCtx(array());
?>

<template v-if="ready">
<div r fxc fxw fs10>
    <div a="tbr" wp50 :style="{
        'background': `url('${pic}') no-repeat center`,
        'background-size': `contain`,
    }">
        <div txc>{{ id }}</div>
    </div>
    <div wp50 fxr fxno v-for="(filterItem, filterName) in filterList">
        <span>
            <input type="checkbox"
                :id="`filter-${id}-${filterItem.name}`"
                v-model="filterItem.value"
                @change="() => filterSave(filterItem.name, filterItem.value)"
            />
        </span>
        <label :for="`filter-${id}-${filterItem.name}`">{{ filterItem.title }}</label>
    </div>
</div>
</template>
<template v-else>
    <div txc>{{ id }}</div>
    <div>- нет данных -</div>
</template>