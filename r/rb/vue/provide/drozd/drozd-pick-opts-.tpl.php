<?
$Self = _rb::self();
//$Self::req_css('drozd');
$_ctx = $Self::tempCtx(array());
?>

<template v-for="(value, name) in pickOpt">
	<?// :checked="o.checked" ?>
    <div fxn>
        <input h12 :id="`pickOpt-${name}`" type="checkbox" v-model="pickOpt[name]"  />

        <label cp :for="`pickOpt-${name}`">{{ name }}</label>
    </div>
</template>

<? if (0) { ?>
    <div>
        <i cp class="material-icons" @click="setPickLevel(-1)">remove</i>
        <i cp class="material-icons" @click="setPickLevel(1)">add</i>
    </div>
<? } ?>
<? if (!1) { ?>
    <div>
        <i cp class="material-icons" @click="pickSelected = getNextPickKeyByLevel(-1)">chevron_left</i>
        <i cp class="material-icons" @click="pickSelected = getNextPickKeyByLevel(1)">chevron_right</i>
    </div>
<? } ?>
