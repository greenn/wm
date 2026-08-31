var validatator = {};

validatator.notEmpty = function(value){
    if (!value) return 'Обязательно для заполнения';
}

validatator.run = function(value, ctx = true){
    //_log('validatator.run', { value, ctx });
    if (ctx === true) { ctx = { type: 'notEmpty' }}
    else if (!ctx) { ctx = { type: 'skip' }}

    var method = validatator[ctx.type] || function(){ return true };
    var error = method(value, ctx);

    return error;

    return {
        error: error,
        value: value,
        //ctx: ctx,
        //method: method,
    }


}