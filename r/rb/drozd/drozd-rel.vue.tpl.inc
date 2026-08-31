<?
$Self = _rb::self();
$nRl = $Self::nc('rel');

//$Self::req_css('drozd');
$Self::req_css('drozd');
?>

<section
    class="<?=$nRl?>"
    @mouseover="inFocus = true"
    @mouseleave="inFocus = false"
>
    <div fxc mr20 fs12 >
        <div fwb fs12 mr2 r :style="{ '--bc': 'grey' }">
            <div a h1 wp100 style="background-color: var(--bc)"></div>
            <div a w1 hp100 :style="{ 'background-color': 'var(--bc)' }"></div>

            <div fxr nobr pl2 @click="!isAlwaysOpen && toggleOpen">
                <span nos v-if="$data.drag">⚛</span>
                <span pl2 nos>rel {{ name2 }}</span>
                <? if (0) { ?><span pl2 nos>active {{ active }}</span><? } ?>

                <template v-if="isOpen">
					<?=rb_tpl('vue', 'provide/drozd/drozd-opts', array('var' => 'pickOpt'))?>
                </template>
            </div>
        </div>
        <div fxc v-if="isOpen">
			<?=rb_tpl('vue', 'provide/drozd/drozd-pick', array())?>
        </div>
    </div>
</section>