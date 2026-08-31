<?
$Self = _kot::self();
$nL = $Self::nc('L');

$Self::req_css('targets');

//tag-name, r-name, tpl-name
_kot::req_vue('ui', 'button', array(), 'ui-button'); //r-name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('table-filter');
_kot::req_vue('table-listing', 'table-targets');
_kot::req_vue('app', 'top-cmd');

?>
<?/*
    <request-bar :tick="updateTime"></request-bar>
*/?>

<div class="<?=$nL?>">
	<?//=kot('app', 'fake', 'tsk/target-1')?>

    <top-cmd>
        <ui-button r-button class="" @click="linkRel('add')" title="Создать шаблон таргета">
            <i class="material-icons">add</i>
            <span>Создать</span>
        </ui-button>

        <ui-button r-button class="" @click="calcCoverage">
            <i class="material-icons">bar_chart</i>
            <span>Пересчитать</span><?//Пересчитать охват?>
        </ui-button>

    </top-cmd>

    <!--<div>
        <table-filter ref="Filter"></table-filter>
    </div>-->

    <div>
        <!--<keep-alive>-->
            <table-targets
                ref="Table"
                :items="list"
                <?//:forecastBusy="busy"?>
                <?//:busy="busy"?>
                <?//@onDelete="onDelete"?>
            ></table-targets>
        <!--</keep-alive>-->
    </div>


</div>