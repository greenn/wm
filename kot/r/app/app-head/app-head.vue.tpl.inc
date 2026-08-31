<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('app-head');

//$Self::req_vue('cmd-base', array(), 'head-cmd-base');
_kot::req_vue('app-user', 'head-snippet', array(), 'user-snippet'); //r-name, tpl-name, tpl-ctx, tag-name
?>

<div fxr2 fxi2="fs" class="<?=$n?>" :class="{ '-hasSubTitle': hasSubTitle }">

    <div class="sep-hw4"></div>

    <lay-section fg tight>
        <div fxva class="<?=$n?>-title">
            <?/*?><div>hasSubTitle: {{ hasSubTitle }} / {{ typeof hasSubTitle }}</div><?*/?>
            <slot></slot>
        </div>
    </lay-section>



    <template v-if="$slots.cmd && $slots.cmd.length > 0">
        <div class="sep-hw2"></div>
        <lay-section tight>
            <div class="<?=$n?>-cmd" fxr fxi="fe">
                <slot name="cmd"></slot>
            </div>
        </lay-section>
    </template>

    <? if (0) { ?>
        <lay-section class="<?=$n?>-user">
            <user-snippet></user-snippet>
        </lay-section>
	<? } ?>

</div>
