<?
$Self = _kot::self();
$nI = $Self::nc('I');
$Self::req_css('targets');

//r-name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('ui', 'content-section');
_kot::req_vue('ui', 'text-field');
_kot::req_vue('ui', 'field-forecast');
?>

<div r class="<?=$nI?>-w">
    <busy-area a="ltrb" :busy="busy" class="-C"></busy-area>

    <top-cmd>
        <ui-button r-button class="" @click="linkRel(item.uid + '/edit')">
            <i class="material-icons">edit</i>
            <span>Изменить</span>
        </ui-button>

        <ui-button r-button class="" @click="aproove" v-if="!item.aprooved">
            <!--<i class="material-icons">verified_user</i>-->
            <i class="material-icons">sync_lock</i><?//pan_tool?>
            <span>Поменять статус</span>
        </ui-button>

        <ui-button r-button class="" @click="reject" v-if="item.aprooved">
            <i class="material-icons">sync_lock</i><?//thumb_down?>
            <span>Поменять статус</span>
        </ui-button>

        <ui-button r-button class="" @click="copy">
            <i class="material-icons">content_copy</i>
            <span>Копировать</span>
        </ui-button>

        <ui-button r-button class="" @click="remove">
            <i class="material-icons">delete</i>
            <span>Удалить</span>
        </ui-button>
    </top-cmd>


    <content-section :title="'Общие сведения'" :open="true">
        <div fxr class="<?=$nI?>-row">
            <text-field class="-mr <?=$nI?>-id" :label="'ID'" :value="item.uid"></text-field>
            <text-field class="-mr <?=$nI?>-date" :label="'Дата и время обновления'" :value="item.date"></text-field>
            <text-field class="<?=$nI?>-aprooved" :label="'Статус'" :value="item.aproovedTitle"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="<?=$nI?>-title" :label="'Наименование'" :value="item.title"></text-field>
        </div>

        <field-forecast class="<?=$nI?>-forecast"
            :value="item.forecast"
            @onCalc="calcCoverage"
            :busy="busyCoverage"
        ></field-forecast>
    </content-section>


    <target-view class="<?=$nI?>-targets"
        ref="targets"
        :targets="item.targets"
        <?/*:forecast="item.forecast"
        :busyCoverage="busyCoverage"
        @onCalcCoverage="calcCoverage"*/?>
    ></target-view>

</div>