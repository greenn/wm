<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('context-menu');

$nCM = $Self::nc('context-menu');

_kot::vue_req('ui-button', 'ui', 'button'); //tag-name, r-name, tpl-name

?>
<?/*
    <request-bar :tick="updateTime"></request-bar>
*/?>
<div r class="<?=$nCM?>-w" :class="{ '-open': open }" ref="modal">
    <ui-button e-button class="" @click="toggle">
        <span class="modal-icon">
            <i class="material-icons">more_vert</i>
        </span>
    </ui-button>
    <div a class="<?=$nCM?>-w">
        <transition name="fade-modal">
            <div class="<?=$nCM?>" v-if="open">
                <ui-button
                    e-button class="<?=$nCM?>-item ft-min"
                    v-for="btn in list"
                    :disabled="btn.disabled"
                    @click="btn.click(btn)"
                    v-show="!btn.hidden"
                    <?//v-show="!{ 'reject': hideReject, 'aproove': hideAproove }[btn.name]"?>
                >
                    <div class="<?=$nCM?>-icon">
                        <i class="material-icons">{{ btn.icon }}</i>
                    </div>
                    <div class="<?=$nCM?>-title" nobr>
                        {{ btn.title }}
                    </div>
                </ui-button>
            </div>
        </transition>
    </div>
</div>