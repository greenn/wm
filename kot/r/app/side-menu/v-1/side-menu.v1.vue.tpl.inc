<?
$Self = _kot::self();
$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc')); //'side-menu'

$Self::req_css('side-menu');
?>

<section class="<?=$n?>">

    <div r class="<?=$n?>-item" v-for="item in list" :num="item.addr">

        <div fxr class="<?=$n?>-link-w" :class="{
            '-border': !item.sub,
            '-expanded': item.expanded,
            <? if (0) { ?>'-selected': item.selected,<? } ?>
            <? if (1) { ?>'-selected': applyParentMethod('side-pane', 'isSelectedMenu', item),<? } ?>
            '-nosub': !item.sub,
        }">
            <a fg class="<?=$n?>-link ft-menu" :class="{ 'nolink': noClick(item) }" @click.prevent="menuClick(item)">
                {{ item.title }}
            </a>
            <a v-if="item.sub" class="<?=$n?>-toggle" @click.prevent="expand(item)">
                <?=kot_i::img('fake/menu-toggle.png')?>
            </a>
        </div>

        <?/**/?>
        <div class="<?=$n?>-sub-w" :class="{ '-expanded': item.expanded }">
            <side-menu v-if="item.sub" :list="item.sub" class="<?=$n?>-sub" :ref="'submenu' + item.addr"></side-menu>
        </div>


        <div r class="<?=$n?>-sep" v-if="item.depth === 0">
            <div a="tb" class="<?=$n?>-sep-line"></div>
        </div>
    </div>

</section>