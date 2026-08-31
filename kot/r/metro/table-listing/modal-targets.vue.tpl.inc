<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('table-listing');
$nM = $Self::nc('modal');
$nMM = $Self::nc('modal-menu');

_kot::vue_req('ui-button', 'ui', 'button'); //tag-name, r-name, tpl-name

?>
<?/*
    <request-bar :tick="updateTime"></request-bar>
*/?>
<div r class="<?=$nM?>-w" :class="{ '-open': open }" ref="modal">
    <ui-button e-button class="" @click="toggle">
        <span class="modal-icon">
            <i class="material-icons">more_vert</i>
        </span>
    </ui-button>
    <div a class="<?=$nMM?>-w">
        <transition name="fade-modal">
            <div class="<?=$nMM?>" v-if="open">
                <ui-button
                    e-button class="<?=$nMM?>-item ft-min"
                    v-for="btn in list"
                    :disabled="btn.disabled"
                    @click="btn.click(btn)"
                    v-show="!btn.hidden"
                    <?//v-show="!{ 'reject': hideReject, 'aproove': hideAproove }[btn.name]"?>
                >
                    <div class="<?=$nMM?>-icon">
                        <i class="material-icons">{{ btn.icon }}</i>
                    </div>
                    <div class="<?=$nMM?>-title" nobr>
                        {{ btn.title }}
                    </div>
                </ui-button>
            </div>
        </transition>
    </div>
</div>