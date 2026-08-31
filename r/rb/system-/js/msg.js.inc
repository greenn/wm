<?/*
*/?>

var msg = function(text, ctx, opt){
    if (!opt) opt = {};
    var fn = opt.warn ? 'warn' : 'log';

    console[fn](text, ctx);
    //alert(text);
}

msg.warning = function(text, ctx, opt){
    if (!opt) opt = {};
    opt.warn = true;

    var warnText = 'Warning! ' + text;
    msg(warnText, ctx, opt)
}