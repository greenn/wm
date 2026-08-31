<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('target-tpl');

$Self::req_vue('target-view');
_kot::req_vue('ui', 'content-section');
?>
<div>
	<? if (1 && isLocalhost) { //#П1-6?>
    <target-view :targets="reslist" class="<?=$n?>-res"></target-view>
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


    <template v-for="(item, index) in list" :key="index">
        <content-section v-if="item" :title="item.title" :toggler="false" :open="true">
            <!--<keep-alive>-->
                <component :is="item.tpl"
                    @onSubmit="add_target(item, $event)"
                    @onRemove="remove_target(item, true)"
                    <?//:saved="inReslist(item)"?>
                    :saved="item.saved"
                    :on_mount="item.on_mount"
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
                busy:value="busySelecter"
            ></ui-select>
        </div>
        <div submit>
            <ui-button r-button :disabled="!selecter || !tplInfo" @click="add_target_handler(selecter)">
                Добавить
            </ui-button>
        </div>
    </content-section>

    <content-section :title="'Справка'" :toggler="false" :icon="'settings'" v-show="list.length">
        <tpl-legend></tpl-legend>
    </content-section>



</div>