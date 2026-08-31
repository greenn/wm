<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('app-head');

_kot::req_vue('ui', 'button', array(), 'ui-button'); //r-name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('app-user', 'head-snippet', array(), 'user-snippet'); //r-name, tpl-name, tpl-ctx, tag-name

//_kot::req_vue('ui', 'icon-mat', array(), 'icon-m');
_kot::req_vue('ui', 'icon-mat', array(), 'icon-mi');

?>
<lay-section class="<?=$n?>">
    <div fxr2 fxi2="fe">

        <div class="<?=$n?>-cmd-base <?=$n?>-ce">
            <ui-button clk="l" small b-button class="-mr" @click="linkBack" title="Перейти назад">
                <icon-mi class="cmd-back">arrow_back_ios</icon-mi>
            </ui-button>

            <ui-button clk="t" small b-button @click="linkPar" title="Перейти наверх">
                <icon-mi class="rotate-90">arrow_back_ios</icon-mi>
            </ui-button>
        </div>

        <div fg class="<?=$n?>-title <?=$n?>-ce">
            <slot></slot>
        </div>

        <div class="<?=$n?>-user <?=$n?>-ce">
            <user-snippet></user-snippet>
        </div>
    </div>
</lay-section>
