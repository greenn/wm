<?
$Self = _rw::name('tool-admin');
$nF = $Self::nc('form');
$_ctx = $Self::tempCtx(array(
	'id' => $Self::nc()
));
$vueName = $_ctx['id'];

rp('ui', 'req', 'field-p');
rb('vue', 'req', 's-field');
rb('vue', 'req', 's-button');


?>
<div class="<?=$nF?>">
    <section ffm>
        <div>name: {{ name }}</div>
        <div>values: {{ values }}</div>
    </section>

    <section fxr="se">
        <template v-if="name">

        </template>

        <template v-if="name === 'create'">
            <s-button @click="create">create</s-button>
            <s-button @click="close">close</s-button>

        </template>
        <template v-else-if="name === 'edit'">
            <s-button @click="update">update</s-button>
            <s-button @click="remove">delete</s-button>
        </template>
    </section>


    <template v-if="has_value && trigger" v-for="(info, name) in struct">
        <s-field :value="values[name]" :name="name" @onChange="values[name] = $event"></s-field>
    </template>
    <template v-else>
        данные не выбраны
    </template>


</div>