<?
$Self = _kot::self();
$_ctx = $Self::tempCtx(array(
	'as' => '',
));

$as = $_ctx['as'];
?>
<template v-if="route.meta.keepAlive">
    <keep-alive>
        <component :is="Component" <?=$as?>/>
    </keep-alive>
</template>
<template v-else>
    <component :is="Component" <?=$as?>/>
</template>