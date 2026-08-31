<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('app-side');

//_kot::req_vue('side-menu');
//_kot::req_vue_v('side-menu', 'v-1');
_kot::req_vue_v('side-menu', 'v-2');


$Self::req_vue('side-head');

_kot::req_vue('app-head', 'cmd-base', array(), 'head-cmd-base');

//_kot::req_vue('ui', 'form/field', array(), 'ui-field');
//$Self::req_vue('form/field', array(), 'ui-field');
?>

<lay-section tight class="<?=$n?>">

    <div fxr fxi="c" mr5>
        <user-snippet fg class="<?=$n?>-user"></user-snippet>
        <head-cmd-base></head-cmd-base>
    </div>

    <div indent="<?=$n?>-after-head"></div>

    <side-menu></side-menu>

	<? if (0) { ?>
        <div indent="<?=$n?>-after-head"></div>
        <pre>{{ $route }}</pre>
	<? } ?>

    <side-head class="<?=$n?>-head"></side-head>

</lay-section>