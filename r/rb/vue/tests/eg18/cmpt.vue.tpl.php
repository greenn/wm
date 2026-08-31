<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    //'dirUrl',
    //'strLess'
);

$Self = _rb::self();
$_ctx = $Self::tempCtx(array());

?>
<div id="v-model-example" class="demo">
    <p>First name: {{ firstName }}</p>
    <p>Last name: {{ lastName }}</p>
    <user-name
        v-model:first-name="firstName"
        v-model:last-name="lastName"
    ></user-name>
</div>