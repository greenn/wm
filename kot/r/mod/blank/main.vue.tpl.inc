<?
$Self = _kmod::self();
$nM = $Self::nc('main');

_kot::req_vue('ui', 'button', array(), 'ui-button');
$Self::req_vue('item', array(), 'blank-item');
?>
<div class="<?=$nM?>">
    <ui-button bu-button title="кнопка" @click="flagToggle = !flagToggle" :busy="flagToggle">
        toggle
    </ui-button>

    <ui-button bu-button title="кнопка" @click="loadItems">
        load
    </ui-button>

    <blank-item v-for="(item, index) in items" :key="index" v-if="items.length" />
    <div v-else>Нет элементов</div>
</div>