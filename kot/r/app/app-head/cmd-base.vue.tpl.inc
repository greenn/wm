<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('app-head');

_kot::req_vue('ui', 'button', array(), 'ui-button'); //r-name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('ui', 'icon-mat', array(), 'icon-mi');

?>

<div fxc class="<?=$n?>-cmd-base">
    <ui-button clk="t" small="rev" b-button
        class="<?=$n?>-cmd-item"
        title="Перейти наверх"
        @click="linkPar"
    >
        <icon-mi class="rotate-90">arrow_back_ios</icon-mi>
    </ui-button>

    <ui-button clk="l" small b-button
        class="<?=$n?>-cmd-item"
        title="Перейти назад"
        @click="linkBack"
    >
        <icon-mi class="cmd-back">arrow_back_ios</icon-mi>
    </ui-button>
</div>
