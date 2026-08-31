<?
$Self = _rb::self();
$nBg = $Self::nc('bg');

//$Self::req_css('drozd');
$Self::req_css('drozd');
?>

<section
    a tp100 zi1000
    class="<?=$nBg?>"
    @mouseover="inFocus = true"
    @mouseleave="inFocus = false"
    tabindex
>
        <div fxr r :style="[dragStyle, bgStyle]">

            <div fxc mr20 fs12 >
                <div :cg="drag.isDragging ? 'on' : ''" fwb fs12 mr2 r :style="titleStyle">
                    <div a h1 wp100 style="background-color: var(--bc)"></div>
                    <div a w1 hp100 :style="{ 'background-color': 'var(--bc)' }"></div>

                    <span nobr pl2 @click="dragClick(toggleOpen)" @mousedown="dragStart" @mouseup="dragStop">
                        <span nos v-if="$data.drag">⚛</span>
                        <span pl2 nos v-if="isOpen || inFocus">bg</span>
                    </span>

					<?=rb_tpl('vue', 'provide/drozd/drozd-opts', array('var' => 'hideOpt', 'if' => 'isOpen'))?>
                </div>

                <template v-if="isOpen && !hideOpt.hide">
					<?=rb_tpl('vue', 'provide/drozd/drozd-opts', array('var' => 'pickOpt'))?>
					<?=rb_tpl('vue', 'provide/drozd/drozd-opts', array('var' => 'bgOpt'))?>
                </template>
            </div>
            <div fxr :style="{ opacity: hideOpt.hide ? '0' : '1' }">
                <div fxc v-if="isOpen">
                    <?=rb_tpl('vue', 'provide/drozd/drozd-pick', array())?>
                </div>
                <div ml10 v-if="isOpen && $slots.default" r>
                    <slot @slot-event="clog('slot-event/1', { $event })"></slot>
                </div>
            </div>
        </div>


</section>