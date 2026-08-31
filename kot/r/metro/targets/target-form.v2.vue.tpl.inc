<?
$Self = _kot::self();
$nF = $Self::nc('F');
$Self::req_css('targets');

//req_vue: -name, tpl-name, tpl-ctx, tag-name
_kot::req_vue('app', 'top-cmd');
_kot::req_vue('ui', 'form-section');
_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
_kot::req_vue('ui', 'busy', array(), 'ui-busy');

_kot::req_vue('target-tpl', 'target-constructor');

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

                <!--<pre>hasTargets: {{ hasTargets }}</pre>-->
                <field-forecast class="<?=$nF?>-forecast"
                    <?//v-if="isMode('update')"?>
                    <?//:disabled="!fields.targets || !fields.targets.length"?>
                    :disabled="!hasTargets"
                    :value="fields.forecast"
                    @onCalc="validateTargets() && calcCoverage()"
                    :busy="busyCoverage"
                ></field-forecast>


	            <? if (true && isLocalhost) { ?>
                    <div dbg mt20>
                        <ui-button w-button class="<?=$nF?>-cmd-item" @click="validate">validate</ui-button>
			            <? if (!true && isLocalhost) { ?><span ml10>validated: {{ validated }}</span><? } ?>
                    </div>
	            <? } ?>
            </template>
        </form-section>


        <!--<div indent="<?/*=$nF*/?>-targets-before"></div>-->



        <!--<pre>fields.targets: {{ fields.targets }}</pre>-->

        <target-constructor
            ref="constructor"
            :mode="mode"
            @onChange="fields.targets = $event"
            <?//:waitData="isMode('update')"?>
        ></target-constructor>


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
                <?//@click="validate() && create()"?>
                @click="validate() && calcCoverage(create)"
                v-show="isMode('create')"
            >Создать</ui-button>

            <ui-button w-button class="<?=$nF?>-cmd-item"
                :disabled="busyForm || !hasChanges "
                <?//@click="validate() && update()"?>
                @click="validate() && calcCoverage(update)"
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