<?
$Self = _kot::self();
$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc')); //'side-menu'

$Self::req_css($Self::relDir('side-menu'));

_kot::req_vue('ui', 'icon-mat', array(), 'icon-m');
_kot::req_vue('ui', 'icon-mat', array(), 'icon-mi');
//kot('ui', 'req_vue_name', 'icon-m');

?>

<section class="<?=$n?>">
    <div r class="<?=$n?>-item" v-for="item in items" :num="item.addr">

        <div fxr fxi="c" class="<?=$n?>-item-w"
            :class="{
                '-expanded': item.expanded,
            }"
        >
            <a cp fg class="<?=$n?>-link"
               :class="[
                   ftLink || 'ft-side-link',
               ]"
               @click.prevent="menuClick(item)"
            >
                {{ item.title }}
            </a>
            <a class="<?=$n?>-toggle"
               v-if="item.sub"
               @click.prevent="expand(item)"
            >
                <icon-m>chevron_right</icon-m>
            </a>
        </div>


        <div class="<?=$n?>-sub-w"
            v-if="item.sub"
            :class="{ '-expanded': item.expanded }"
        >
            <side-menu class="<?=$n?>-sub"
                :list="item.sub"
                :depth="item.depth"
                :ref="'submenu' + item.addr"
            ></side-menu>
        </div>


        <div cp fxr fxi="c" class="<?=$n?>-button" v-if="item['add-project']">
            <icon-mi>add_circle</icon-mi>
            <span class="ft-side-button">Add new project</span>
        </div>

        <div cp fxr fxi="c" class="<?=$n?>-button" v-if="item['add-task']">
            <icon-mi>add_circle</icon-mi>
            <span class="ft-side-button">Add a new task</span>
        </div>

        <?//01?>
        <div class="<?=$n?>-sep"></div>

    </div>

</section>