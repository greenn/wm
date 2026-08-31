var buttonP = {};

//000
buttonP.cmptName = function(cmpt){
    return [cmpt.name || 'button', '(', cmpt._index, ')'].join('');
}

//|buildData|makdeData|
buttonP.buildData = function(ctx, base){// ctx = $attrs, base = defauls
    //_log('buttonP.buildData|1', { ctx: _clearObject(ctx), base });

    var data = ctx.data || {};

    _.each(ctx, function(val, name){

        //if (name === 'class') data['ns'] = val;
        if (name === 'class') {
            val = _.split(val, /\s/);
            val = _.transform(val, function(res, name){
                res[name] = true
            }, {})
            if (val.hasOwnProperty('-busy')) {
                //за класс {-busy} отвечает данная {busy}
                data['busy'] = true;
                delete val['-busy'];
            }
        } else if (name !== 'data') {
            data[name] = val;
        }


    })

    let resData = _.defaults({}, base, data, {
        text: '',
        name: 'button',

            disabled: false,
            type: 'text',

        busy: false,
        class: '',

    })

    //_log('buttonP.buildData|2', { data, base, resData });

    return resData;
}