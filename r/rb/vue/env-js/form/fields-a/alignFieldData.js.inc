var alignFieldData = function(data, ctx){
    if (!ctx) ctx = {};

    if (_.isString(data)) {
        data = { value: data }
    } else if (_.isArray(data)) {
        data = {
            name: data[0],
            label: data[1],
            placeholder: data[2],
            disabled: data[3] || false,
            //required: data[2] || false,
        }
    }

    data = _.extend({
        type: 'text',
        label: true,
        tpl: 'field',
        name: ctx.name,
        placeholder: true,
        disabled: false,
        value: '',
        required: false,
        validation: false,
    }, data);

    if (data.label === true) data.label = data.name;
    if (data.placeholder === true) data.placeholder = data.label;
    if (data.required && !data.validation) data.validation = true;

    return data;
}