<?
$Self = _kmod::self();
$nC = $Self::nc('C');

_kot::req_vue('ui', 'button', array(), 'ui-button');
?>
<div txr class="<?=$nC?>">
    <ui-button bu-button title="кнопка">
        save
    </ui-button>
    <div ib class="sep-hw3"></div>
    <ui-button b-button title="кнопка">
        cancel
    </ui-button>
</div>