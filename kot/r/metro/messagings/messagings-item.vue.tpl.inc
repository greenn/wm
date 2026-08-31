<?
$Self = _kot::self();
$nI = $Self::nc('I');
$Self::req_css('messagings');

//r-name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('ui', 'content-section');
_kot::req_vue('ui', 'text-field');
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
            <text-field class="<?=$nI?>-aprooved" :label="'Статус'" :value="item.statusTitle"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="<?=$nI?>-title" :label="'Название рассылки'" :value="item.title"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="-mr <?=$nI?>-aim" :label="'Цель рассылки'" :value="item['bulk-aim']"></text-field>
            <text-field class="<?=$nI?>-type" :label="'Тип оповещения'" :value="item['bulk-type']"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="-mr <?=$nI?>-channel" :label="'Канал информирования'" :value="item['channel']"></text-field>
        </div>
    </content-section>

    <content-section :icon="'record_voice_over'" :title="'Критерии выборки получателей рассылки'" :open="true">

        Сообщение будет отправлено только загруженным получателям.
        <?/*
            <div fxr class="<?=$nI?>-row"></div>
            Не использовать критерии выборки для отправки рассылки
            Отправка рассылки всем пассажирам
            Отправка только пассажирам согласно правилам
        */?>
    </content-section>


    <content-section :icon="'settings'" :title="'Параметры'" :open="true">
	    <?=kot_i::img('fake/messagings/chrome_7XBmtHHsqi.png')?>
    </content-section>

    <content-section :icon="'info'" :title="'Повторная отправка'" :open="true">
	    <?=kot_i::img('fake/messagings/chrome_b8U2wt0To3.png')?>

    </content-section>

    <content-section :icon="'slow_motion_video'" :title="'Статус доставки'" :open="true">
	    <?=kot_i::img('fake/messagings/chrome_OAFkd1vAbP.png')?>
    </content-section>

    <content-section :icon="'attachment'" :title="'Загруженные файлы'" :open="true">
        Нет файлов
    </content-section>

    <content-section :icon="'info'" :title="'Данные для заполнения шаблона'" :open="true">
	    <?=kot_i::img('fake/messagings/chrome_JGtIPkpNUb.png')?>
    </content-section>

    <content-section :icon="'textsms'" :title="'Sms'" :open="true">
	  <?=kot_i::img('fake/messagings/chrome_SgXDjYkRJh.png')?>
    </content-section>

</div>