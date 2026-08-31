<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    //'dirUrl',
    //'strLess'
);

$Self = _rb::self();
$_ctx = $Self::tempCtx(array());

?>
<input
    type="text"
    :value="firstName"
    @input="$emit('update:firstName', $event.target.value)"
/>

<input
    type="text"
    :value="lastName"
    @input="$emit('update:lastName', $event.target.value)"
/>