<?
$Self = _kot::self();
$nTWI = $Self::nc('TWI'); //target-view-info
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'content-section'); //dbg
_kot::req_vue('ui', 'busy', array(), 'ui-busy');

$Self::req_vue('passes/station-freq-tpl3', array(), 'tpl3-passes--station-freq');
$Self::req_vue('passes/passes-qy-tpl3', array(), 'passes-qy--station-freq');

?>
<template v-if="alignedTargets && alignedTargets.length">
    <template v-for="(item, index) in alignedTargets">
        <div class="<?=$nTWI?>-title ft-text w-reg">{{ item.title }}</div>
        <div class="<?=$nTWI?>-item ft-min" :title="item.title" v-if="item">
            <component :is="item.tpl3" :cfg="item.cfg" />
        </div>
        <div class="<?=$nTWI?>-busy" v-else>
            <ui-busy :size="3" :visible="true"></ui-busy>
        </div>
        <div r v-if="index < alignedTargets.length - 1" class="<?=$nTWI?>-sep"></div>
    </template>
</template>
<template v-else>
    <div class="<?=$nTWI?>-empty">нет таргетирования</div>
</template>