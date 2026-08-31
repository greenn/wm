<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('target-tpl');

$Self::req_vue('target-view');
_kot::req_vue('ui', 'content-section');
?>
<div>

    <template v-for="(item, index) in list" :key="index">
        <content-section v-if="item" :title="item.title" :toggler="false" :open="true">
            <!--<keep-alive>-->
                <component :is="item.tpl"
                    @onRemove="remove_target(item)"
                    :fetchData="item.fetchData"
                    @assignData="add_target(item, $event)"
                />
            <!--</keep-alive>-->
        </content-section>
    </template>

    <content-section class="<?=$n?>-selecter"
        :title="'Добавить таргетирование'" :toggler="false"
    >
        <div select>
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

	<? if (0 && isLocalhost) { //#П1-6?>
        <target-view :targets="reslist" class="<?=$n?>-res"></target-view>
	<? } ?>

	<? if (0 && isLocalhost) { //#П1-6?>
        <target-view :targets="list"></target-view>
	<? } ?>


	<? if (0 && isLocalhost) { ?>
        <div class="-red w-bld">dbg</div>
        <content-section :title="'Таргеты в шаблоне'" :toggler="false" :icon="'apps'" class="<?=$n?>-res">
            <template v-if="reslist.length">
                <component v-for="item in reslist" :is="item.tpl2" :cfg="item.cfg"/>
            </template>
            <template v-else>
                <div class="<?=$n?>-empty">Пока ничего не выбрано</div>
            </template>
        </content-section>
	<? } ?>

    <content-section :title="'Справка'" :toggler="false" :icon="'settings'" v-show="list.length">
        <tpl-legend></tpl-legend>
    </content-section>



</div>