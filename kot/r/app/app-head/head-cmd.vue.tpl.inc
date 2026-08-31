<?
$Self = _kot::self();
$nHC = $Self::nc('HC'); //head-cmd
$Self::req_css('app-head');

_kot::req_vue('ui', 'button', array(), 'ui-button');
?>


<div txr class="<?=$nHC?>">
    <ui-button bu-button title="кнопка" @click="linkPar">
        save
    </ui-button>
    <div ib class="sep-hw3"></div>
    <ui-button b-button title="кнопка" @click="linkPar">
        cancel
    </ui-button>
</div>

