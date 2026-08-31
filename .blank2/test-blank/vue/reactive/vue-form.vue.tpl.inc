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

    <div>
        <label>data1</label>
        <input v-model="form.data1" />
    </div>
    <div>
        <label>data2</label>
        <input v-model="form.data2" />
    </div>
    <div>
        <button @click="addData3">data3</button>
        <input v-model="data3" />
    </div>
    <div>
        <button @click="addData4">data4</button>
        <input v-model="data4" />
    </div>
    <pre>form: {{ form }}</pre>
</div>