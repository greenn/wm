<?
$Self = _kot::self();
$nF = $Self::nc('F');
$Self::req_css('messagings');

//req_vue: -name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('app', 'top-cmd');
_kot::req_vue('ui', 'form-section');
_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
_kot::req_vue('ui', 'busy', array(), 'ui-busy');

?>

<div r class="<?=$nF?>-w">
    <busy-area a="ltrb" :busy="busy" class="-C"></busy-area>

    <top-cmd>
        <?/*
            <button @click="$root.__('sys-msg', 'showError')">error</button>

            <ui-button w-button class="-mr" @click="calcCoverage" v-if="mode === 'update'">
                <i class="material-icons">bar_chart</i>
                <span>Прогноз охвата</span>
            </ui-button>
        */?>
    </top-cmd>

    <? if (!1) { ?>
        <pre>fields: {{ fields }}</pre>
    <? } ?>
    <? if (0) { ?>
        <pre>hasChanges: {{ hasChanges }}</pre>
        <pre>fields: {{ fields }}</pre>

        <pre>fields: {{ fields }}</pre>
        <pre>readySubmit: {{ readySubmit }}</pre>
        <pre>busyForm: {{ busyForm }}</pre>
    <? } ?>


    <div r class="<?=$nF?>">
        <form-section>
            <template v-slot:headline>
                <i class="material-icons">assistant</i>
                Общие сведения
            </template>

            <template v-slot:content>
                <?//<ui-field @onChange="fields.title = $event" ref="title" :label="'Наименование шаблона'"></ui-field>?>
                <ui-field ref="title"
                    v-model:value="fields.title"
                    :label="'Наименование'"
                    :req="true"
                    <?//:warnMsg="true"?>
                ></ui-field>

                <div>
	                <?=kot_i::img('fake/messagings-edit/chrome_TFLA7jRuhh.png')?>
                </div>

	            <? if (true && isLocalhost) { ?>
                    <div dbg mt20>
                        <ui-button w-button class="<?=$nF?>-cmd-item" @click="validate">validate</ui-button>
			            <? if (!true && isLocalhost) { ?><span ml10>validated: {{ validated }}</span><? } ?>
                    </div>
	            <? } ?>
            </template>
        </form-section>


        <content-section :icon="'record_voice_over'" :title="'Критерии выборки получателей рассылки'" :toggler="false" :open="true">
	        <?=kot_i::img('fake/messagings-edit/chrome_cFz26d8CpT.png')?>
        </content-section>

        <content-section :icon="'settings'" :title="'Параметры'" :toggler="false" :open="true">
		    <?=kot_i::img('fake/messagings-edit/chrome_PeHDgFyd5H.png')?>
        </content-section>

        <content-section :icon="'info'" :title="'Повторная отправка'" :toggler="false" :open="true">
		    <?=kot_i::img('fake/messagings-edit/chrome_ndzZ3qAAu9.png')?>
        </content-section>

        <content-section :icon="'attachment'" :title="'Загруженные файлы'" :toggler="false" :open="true">
            <ui-button r-button class="">
                <i class="material-icons">folder</i>
                <span>Загрузить</span>
            </ui-button>
        </content-section>

        <content-section :icon="'info'" :title="'Данные для заполнения шаблона'" :toggler="false" :open="true">
		    <?=kot_i::img('fake/messagings-edit/chrome_YMaLGoe0Hg.png')?>
        </content-section>

        <content-section :icon="'textsms'" :title="'Sms'" :toggler="false" :open="true">
		    <?=kot_i::img('fake/messagings-edit/chrome_orBLFhUVhT.png')?>
        </content-section>



        <div fxr="fe">

            <ui-busy left :visible="busyForm"></ui-busy>

            <ui-button w-button class="<?=$nF?>-cmd-item"
                :disabled="busyForm"
                @click="linkPar"
            >Отмена</ui-button>

            <ui-button w-button class="<?=$nF?>-cmd-item"
                :disabled="busyForm"
                @click="reset"
                v-show="isMode('create')"
            >Сбросить</ui-button>

            <ui-button w-button class="<?=$nF?>-cmd-item"
                :disabled="busyForm "
                @click="validate() && create()"
	            <?//@click="validate() && calcCoverage(create)"?>
                v-show="isMode('create')"
            >Создать</ui-button>

            <ui-button w-button class="<?=$nF?>-cmd-item"
                :disabled="busyForm || !hasChanges "
                @click="validate() && update()"
	            <?//@click="validate() && calcCoverage(update)"?>
                v-show="isMode('update')"
            >Сохранить</ui-button>

            <? if (0) { ?>
                <span>&nbsp;&nbsp;</span>
                <span>hasChanges: {{ hasChanges }}</span>

                <span>&nbsp;&nbsp;</span>
                <span>validated: {{ validated }}</span>
            <? } ?>

        </div>

</div>


</div>