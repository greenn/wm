<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('target-tpl');

$Self::req_vue('target-view');
$Self::req_vue('target-view-info');
$Self::req_vue('tpl-legend');
_kot::req_vue('ui', 'content-section');
?>
<div>

	<? if (!1 && isLocalhost) { //#П1-6?>
        <target-view :targets="list" :toggler="true"></target-view>
	<? } ?>

	<? if (!1 && isLocalhost) { //#П1-6?>
        <content-section :title="'Таргеты в таблице'" :toggler="false" :icon="'apps'">
            <target-view-info :targets="list"></target-view-info>
        </content-section>
	<? } ?>


    <template v-for="(item, index) in list" :key="index">
        <content-section v-if="item" :title="item.title" :toggler="false" :open="true">
            <!--<keep-alive>-->
                <!--<b class="-blue">target: {{ item.tpl }}</b>-->
                <? if (!1) { ?><pre>item.cfg: {{ item.cfg || '-' }}</pre><? } ?>
                <component :is="item.tpl"
                    @onRemove="remove_target(index)"
                    @onChange="onTargetUpdate(index, $event)"
                    :initData="item.initData"<?// для update?>
                    :ref="function(el) { item.ref = el }"
                    :trgName="item.name"

                    <? if (0) { ?>
                        :setData="item.cfg"
                        :waitData="waitData"
                        :fetchData="item.fetchData"
                        @onChange="onTargetUpdate(item, $event)"
                        <?//@onChange="item.onChange($event)"?>
                    <? } ?>
                ></component>
            <!--</keep-alive>-->
        </content-section>
    </template>


    <content-section class="<?=$n?>-selecter"
        :title="'Добавить таргетирование'" :toggler="false"
    >
        <div select>
            <? if (isLocalhost) { ?>
                <pre r style="left: -120px">
                    {{ tplInfo && tplInfo[selecter] && tplInfo[selecter].tpl }}
                    {{ tplInfo && tplInfo[selecter] && tplInfo[selecter].cat }}

                    tpl1
                    {{ tplInfo && tplInfo[selecter] && tplInfo[selecter]['tpl-file'] }}.vue.js
                    {{ tplInfo && tplInfo[selecter] && tplInfo[selecter]['tpl-file'] }}.vue.tpl
                    $Self::req_vue('{{ tplInfo && tplInfo[selecter] && tplInfo[selecter].name }}-tpl', array(), '{{ tplInfo && tplInfo[selecter] && tplInfo[selecter].tpl }}');

                    tpl2
                    {{ tplInfo && tplInfo[selecter] && tplInfo[selecter]['tpl2-file'] }}.vue.js
                    {{ tplInfo && tplInfo[selecter] && tplInfo[selecter]['tpl2-file'] }}.vue.tpl
                    $Self::req_vue('{{ tplInfo && tplInfo[selecter] && tplInfo[selecter].name }}-tpl2', array(), '{{ tplInfo && tplInfo[selecter] && tplInfo[selecter].tpl2 }}');
                </pre>
            <? } ?>
            <ui-select
                <?//:label="false"?>
                <?//:bindClick="true"?>
                :options="selecterOptions"
                v-model:value="selecter"
                busy:value="selecterBusy"
            ></ui-select>
        </div>
        <div submit>
            <ui-button r-button :disabled="!selecter || !tplInfo" @click="add_target(selecter)">
                Добавить
            </ui-button>
        </div>
    </content-section>


    <? if (0) { ?>
        <content-section :title="'Справка'" :toggler="false" :icon="'settings'" v-show="list.length">
            <tpl-legend></tpl-legend>
        </content-section>
    <? } ?>

</div>