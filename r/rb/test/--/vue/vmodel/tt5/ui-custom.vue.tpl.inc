<div fxr>
    ui-custom:
    <ui-field v-model:value="localFieldValue"></ui-field>

    <ui-field :value="localFieldValue" @update:value="localFieldValue = $event"></ui-field>

    <ui-field :value="fieldValue" @update:value="$emit('update:fieldValue', $event)"></ui-field>

</div>