<?
$Self = _kot::self();
$nI = $Self::nc('I');
$Self::req_css('tpl_messagings');

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
            <text-field class="<?=$nI?>-title" :label="'Наименование шаблона'" :value="item.title"></text-field>
        </div>

        <div fxr class="<?=$nI?>-row">
            <text-field class="<?=$nI?>-title" :label="'Наименование рассылки'" :value="item['bulk-title']"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="<?=$nI?>-title" :label="'Цель рассылки'" :value="item['bulk-aim']"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="<?=$nI?>-title" :label="'Тип оповещения'" :value="item['bulk-type']"></text-field>
        </div>
        <div fxr class="<?=$nI?>-row">
            <text-field class="<?=$nI?>-title" :label="'Включённые каналы информирования'" :value="item['channel']"></text-field>
        </div>
    </content-section>


    <content-section :icon="'info'" :title="'Загруженные файлы'" :open="true">
		<?=kot_i::img('fake/tpl_messagings/chrome_4pC8DT8hVU.png')?>
    </content-section>

    <content-section :icon="'info'" :title="'Данные для заполнения шаблона'" :open="true">
		<?=kot_i::img('fake/tpl_messagings/chrome_7E3LrN0WiX.png')?>
    </content-section>

    <content-section :icon="'computer'" :title="'Уведомление в ЛК'" :open="true">
		<?=kot_i::img('fake/tpl_messagings/chrome_mcZzrIckZO.png')?>
    </content-section>

    <content-section :icon="'email'" :title="'E-mail'" :open="!true">
		<?=kot_i::img('fake/tpl_messagings/chrome_aktjxIQ6YW.png')?>
    </content-section>

    <content-section :icon="'textsms'" :title="'Sms'" :open="!true">
		<?=kot_i::img('fake/tpl_messagings/chrome_kA4z6tBWPF.png')?>
    </content-section>

    <content-section :icon="'phonelink_ring'" :title="'Push-уведомление'" :open="!true">
		<?=kot_i::img('fake/tpl_messagings/chrome_nGhJZIDPKY.png')?>
    </content-section>


</div>