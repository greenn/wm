<?
$Self = _kmod::self();
$nT = $Self::nc('T'); //tombs
$Self::req_css('catalog');

_kot::req_vue('ui', 'button', array(), 'ui-button');
$Self::req_vue('catalog-tomb', array(), 'catalog-tomb');
?>
<div class="<?=$nT?>">

        <div fxr>

            <div fxr mr10>
                <label mr10 for="<?=$nT?>-n-from">с</label>
                <div><input w40 id="<?=$nT?>-n-from" v-model.number="n.start" /></div>
            </div>
            <div fxr mr10>
                <label mr10 for="<?=$nT?>-n-to">по</label>
                <div><input w40 id="<?=$nT?>-n-to" v-model.number="n.cur" /></div>
            </div>
            <div w20></div>

            <div fxr mr10>
                <label mr10 for="<?=$nT?>-n-max">max</label>
                <div><input disabled w40 id="<?=$nT?>-n-max" :value="n.max" /></div>
            </div>
            <div>
                <ui-button small b-button
                    @click="n.start = n.min; n.cur = n.max"
                >
                    Все
                </ui-button>
            </div>
            <div w20></div>

            <div mr10>
                <ui-button small b-button @click="nAdd()">
                    Добавить
                </ui-button>
            </div>
            <div>
                <div><input w40 id="<?=$nT?>-n-plus" v-model.number="n.plus" /></div>
            </div>

            <div w20></div>

            <div fxr>
                <label mr10 for="<?=$nT?>-n-only-lock">только</label>
                <div mr10><input type="checkbox" id="<?=$nT?>-n-only-lock" v-model="n.onlyLock" /></div>
                <div><input w140 id="<?=$nT?>-n-only" v-model="n.only" /></div>
            </div>

        </div>

    <div fxr pt8>
        <div>
            <ui-button small b-button
                @click="updateAll"
            >
                Все перестроить
            </ui-button>
        </div>
        <div w20></div>
        <div fxr>
            <div>
                переключить на
            </div>
            <ui-button s-button small ml5
                v-for="viewName in viewNames"
                cp @click="setView(viewName)"
            >
                {{ viewName }}
            </ui-button>

        </div>
    </div>

    <div fxr fxw>
        <div fxc mr20 mt10 v-for="(filterItem, filterName) in filters">

            <label fs11 :for="`filter-${filterItem.name}`">{{ filterItem.title }}</label>

            <div fxr>
                <span>
                    <ui-button small b-button fs12
                        @click="setFilter(filterName, filterItem.value)"
                    >Проставить</ui-button>
                </span>
                <span>
                    <input type="checkbox"
                        :id="`filter-${filterItem.name}`"
                        v-model="filterItem.value"
                    />
                </span>
            </div>



        </div>
    </div>

    <div fxr fxw class="<?=$nT?>-c">

        <? if (1) {?>
            <div class="<?=$nT?>-ci"
                v-for="(num, index) in nList" :key="num"
            >
                <catalog-tomb
                    :ref="`item-${num}`"
                    :id="num"
                ></catalog-tomb>
            </div>
		<? } else { ?>
            <catalog-tomb
                class="<?=$nT?>-ci"
                v-for="(num, index) in nList" :key="index"
                :ref="`item-${num}`"
                :key="index"
                :id="num"
            ></catalog-tomb>
		<? } ?>

    </div>
</div>