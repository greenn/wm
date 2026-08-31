<?
$Self = _kot::self();
$n = $Self::nc();

_kot::req_vue('ui', 'button', array(), 'ui-button');

//_kot::req_vue('target-tpl', 'card/card-factor-tpl', array(), 'tpl-card--card-factor');
//_kot::req_vue('target-tpl', 'card/card-factor-tpl2', array(), 'tpl2-card--card-factor');

_kot::req_vue('target-tpl', 'card-v2/card-factor-tpl', array(), 'tpl-card2--card-factor');
_kot::req_vue('target-tpl', 'card-v2/card-factor-tpl2', array(), 'tpl2-card2--card-factor');

?>
<div>

	<? if (1) { ?>
        <pre>target2: {{ target2 }}</pre>

        <tpl-card2--card-factor
            ref="target2"
            @onChange="update('target2', $event)"
            :initData="target2"
        ></tpl-card2--card-factor>

		<? if (1) { ?>
            <tpl2-card2--card-factor
                :cfg="target2"
            ></tpl2-card2--card-factor>
		<? } ?>
	<? } ?>


	<? if (!1) { ?>
        <pre>target1: {{ target1 }}</pre>

        <tpl-card--card-factor
            ref="target1"
            @onChange="update('target1', $event)"
            :initData="target1"
        ></tpl-card--card-factor>

        <? if (1) { ?>
            <tpl2-card--card-factor
                :cfg="target1"
            ></tpl2-card--card-factor>
        <? } ?>


	<? } ?>



</div>
