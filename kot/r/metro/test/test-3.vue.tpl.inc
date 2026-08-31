<?
$Self = _kot::self();
$n = $Self::nc();

_kot::req_vue('ui', 'button', array(), 'ui-button');

_kot::req_vue('target-tpl', 'passes/station-freq-tpl', array(), 'tpl-passes--station-freq');
_kot::req_vue('target-tpl', 'passes/station-freq-tpl2', array(), 'tpl2-passes--station-freq');

_kot::req_vue('target-tpl', 'passes/passes-qy-tpl', array(), 'tpl-passes--passes-qy');
_kot::req_vue('target-tpl', 'passes/passes-qy-tpl2', array(), 'tpl2-passes--passes-qy');
_kot::req_vue('target-tpl', 'passes/passes-qy-tpl3', array(), 'tpl3-passes--passes-qy');
?>
<div>


	<? if (0) { ?><? } ?>


	<? if (1) { ?>
        <ui-button
            @click="function(){ $refs.target2.validate(!!true && {
                validateOnChange: true,
                stopValidateOnSuccess: true,
            }) }"
        >validate2</ui-button>

        <pre>target2: {{ target2 }}</pre>
        <tpl-passes--passes-qy
            ref="target2"
            @onChange="update('target2', $event)"
            :initData="target2"
        ></tpl-passes--passes-qy>

        <tpl2-passes--passes-qy
            :cfg="target2"
        ></tpl2-passes--passes-qy>

		<? if (1) { ?>
            <tpl3-passes--passes-qy
                :cfg="target2"
            ></tpl3-passes--passes-qy>
		<? } ?>
        <hr />
    <? } ?>


    <? if (!1) { ?>

        <? if (1) { ?>


            <ui-button
                @click="function(){ $refs.target2.validate(!!true && {
                    validateOnChange: true,
                    stopValidateOnSuccess: true,
                }) }"
            >validate2</ui-button>

            <select-station
                ref="target2"
                v-model:value="target1['station']"
                v-model:checkbox="target1['station-fix']"
            ></select-station>
        <? } ?>

        <hr />


        <? if (1) { ?>
            <pre>{{ target1 }}</pre>

            <ui-button @click="function(){ $refs.target1.validate() }">validate1</ui-button>


            <tpl-passes--station-freq
                ref="target1"
                @onChange="update1"
                :initData="target1"
            ></tpl-passes--station-freq>

            <? if (1) { ?>
                <tpl2-passes--station-freq
                    :cfg="target1"
                ></tpl2-passes--station-freq>
            <? } ?>

        <? } ?>

    <? } ?>
</div>
