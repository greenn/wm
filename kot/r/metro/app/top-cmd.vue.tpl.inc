<?
$Self = _kot::self();
$nTC = $Self::nc('top-cmd');
$Self::req_css('app');

_kot::req_vue('ui', 'button', array(), 'ui-button'); //r-name, tpl-name, tpl-ctx, tag-name

?>

<div class="<?=$nTC?>">

    <ui-button w-button="wide" @click="linkBack" title="Перейти назад">
        <i class="material-icons cmd-back">arrow_back_ios</i>
    </ui-button>

        <ui-button w-button="wide" @click="linkPar" title="Перейти наверх">
            <i class="material-icons rotate-90">arrow_back_ios</i>
        </ui-button>

    <slot></slot>

</div>


