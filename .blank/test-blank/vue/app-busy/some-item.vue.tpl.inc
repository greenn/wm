<?
$Self = _rt::name('app-busy');
//$Self::req_vue('some-item');
$n = $Self::nc();
?>

<div class="<?=$n?>-item">
    <h3>item</h3>
    <button @click="busy.api = !busy.api">toggle: api</button>
    <div>busy: {{ busy }}</div>
    <div>isBusy: {{ isBusy() }}</div>
</div>