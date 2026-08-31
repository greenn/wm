<?
$Self = _kot::self();
$Self::req_css('target-tpl');

$nT2 = $Self::nc('T2');
$nT2L = $Self::nc('T2L'); //tpl2-list

_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>
<div fxr fxw class="<?=$nT2?> <?=$nT2L?>">

    <div>
		<? if (!1) { ?><pre>list: {{ list }}</pre><? } ?>
		<? if (!1) { ?><pre>info: {{ info }}</pre><? } ?>
    </div>

    <span class="-pr" v-if="label">{{ label }}</span>
    <div class="<?=$nT2L?>-list">
        <ui-busy v-if="busy" :visible="true"></ui-busy>
        <template v-else-if="!list || !list.length">
            <b class="<?=$nT2?>-fix -warn">- выбрать -</b>
        </template>
        <template v-else>


            <span v-for="(id, index) in list">
                <template v-if="id && valueTitle(id) !== '-'">
                    <b class="<?=$nT2?>-fix">{{ valueTitle(id) }}</b>
                    <span class="comma" v-if="index < list.length - 1">,</span>
                </template>
            </span>

            <?/*<span v-for="(title, index) in titleList">
                <b class="<?=$nT2?>-fix">{{ title }}</b>
                <span class="comma" v-if="index < titleList.length - 1">,</span>
            </span>*/?>
        </template>
    </div>


</div>