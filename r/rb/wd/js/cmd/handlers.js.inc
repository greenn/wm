<? $js; $n; ?>

var cmdDb = {};

<? include $js['cmd/handlers/o']; ?>

<? include $js['cmd/handlers/op']; ?>

<? include $js['cmd/handlers/hoverable']; ?>

<? include $js['cmd/handlers/shade']; ?>

<? include $js['cmd/handlers/off']; ?>

<?/*
    ctx
        null - skip
        isObject - merge
        else - defState
*/?>
var get_cmd = function(name, ctx, self){
    var baseConf = cmdDb[name];
    if (!_.isNull(ctx) && !_.isObject(ctx)) {
        ctx = { defState: ctx };
    }
    if (ctx.name) {
        //если меняем name, в контексте, то меняем дефолтное название кнопки
        baseConf.buttonText = ctx.name;
    }
    var resConf = _.defaultsDeep({ self: self }, ctx, baseConf, { name: name });;
    //console.log('get_cmd')
    return resConf;
}

var get_cmd_conf = function(conf){
    if (typeof conf === 'string') {
        conf = get_cmd(conf);
    } else if (_.isArray(conf)) {
        conf = get_cmd(conf[0], conf[1], conf[2]);
    }
    return conf;
}