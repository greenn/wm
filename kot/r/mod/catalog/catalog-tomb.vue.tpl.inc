<?
$Self = _kmod::self();
$nTI = $Self::nc('TI'); //tombs-item
?>
<div class="<?=$nTI?>" r>
    <template v-if="loadingData">
        <?=$Self::tpl('catalog-tomb.vue.tpl/catalog-tomb-loading')?>
    </template>
    <template v-else>
        <div fxr>
            <ui-button s-button small v-for="menu in viewsMenu"
                :class="{
                    '-selected': viewName === menu.name,
                    '-hover': menu.hover,
                }"
                cp @click="viewName = menu.name"
                @mouseenter="menu.hover = true"
                @mouseleave="menu.hover = false"
            >
                {{ menu.title || menu.name }}
            </ui-button>
        </div>

        <section v-if="viewName === 'info'" key="info">
			<?=$Self::tpl('catalog-tomb.vue.tpl/catalog-tomb-info')?>
        </section>

        <section v-if="viewName === 'view'" key="view">
			<?=$Self::tpl('catalog-tomb.vue.tpl/catalog-tomb-view')?>
        </section>

        <section v-if="viewName === 'cmd'" key="cmd">
			<?=$Self::tpl('catalog-tomb.vue.tpl/catalog-tomb-cmd')?>
        </section>

        <section v-if="viewName === 'filter'" key="filter">
			<?=$Self::tpl('catalog-tomb.vue.tpl/catalog-tomb-filter')?>
        </section>


    </template>

</div>