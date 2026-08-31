<?
$Self = _rb::self();
//$Self::req_css('drozd');
$_ctx = $Self::tempCtx(array(
    'var' => 'opts', // pickOpt, bgOpts
    'if' => '',
));

$var = $_ctx['var'];
$a_if = attr::out_val('v-if', $_ctx['if']);
?>

<template <?=$a_if?> v-for="(value, name) in <?=$var?>">
	<?// :checked="o.checked" ?>
    <div fxn>
        <input h12 :id="`<?=$var?>-${name}`" type="checkbox" v-model="<?=$var?>[name]"  />

        <label cp :for="`<?=$var?>-${name}`">{{ name }}</label>
    </div>
</template>