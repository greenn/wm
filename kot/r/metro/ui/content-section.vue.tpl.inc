<?
$Self = _kot::self();
$nCS = $Self::nc('CS');
$Self::req_css('ui');

?>
<section class="<?=$nCS?>" :class="{ '-closed': closed, '-hover': hover }">
    <div r class="<?=$nCS?>-head">
        <i va class="material-icons">{{ icon || 'info' }}</i>
        {{ title }}

        <ui-button e-button class="<?=$nCS?>-toggle"
            @click="toggle" @hover="hover = $event"
            v-show="toggler !== false"
        >
            <span class="material-icons">expand_less</span>
        </ui-button>
    </div>
    <transition name="scale" mode="out-in"> <?//scale / slidedown / fade / fade2?>
        <div class="<?=$nCS?>-с" v-if="!closed || (toggler === false)">
            <slot></slot>
        </div>
    </transition>


</section>