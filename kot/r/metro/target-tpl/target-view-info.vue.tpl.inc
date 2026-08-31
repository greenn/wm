<?
$Self = _kot::self();
$nTWI = $Self::nc('TWI'); //target-view-info
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'content-section'); //dbg
_kot::req_vue('ui', 'busy', array(), 'ui-busy');

$Self::req_vue('passes/station-freq-tpl3', array(), 'tpl3-passes--station-freq');
$Self::req_vue('passes/passes-qy-tpl3', array(), 'passes-qy--station-freq');

?>
<template v-if="targets && targets.length">
    <template v-for="(item, index) in targets">
        <div class="<?=$nTWI?>-title ft-text w-reg">{{ item.title }}</div>
        <!--<pre>item: {{ item }}</pre>-->
        <!--<pre>cfg: {{ item.cfg }}</pre>-->
        <div class="<?=$nTWI?>-item ft-min" :title="item.tpl && item.tpl.title"  v-if="item">
            <!--tpl3: {{ item.tpl3 }}-->
            <!--<pre>cfg: {{ item.cfg }}</pre>-->
            <component :is="item.tpl && item.tpl.tpl3" :cfg="item" />
        </div>
        <div class="<?=$nTWI?>-busy" v-else>
            <ui-busy :size="3" :visible="true"></ui-busy>
        </div>
        <div r v-if="index < targets.length - 1" class="<?=$nTWI?>-sep"></div>
    </template>
</template>
<template v-else>
    <div class="<?=$nTWI?>-empty">нет таргетирования</div>
</template>