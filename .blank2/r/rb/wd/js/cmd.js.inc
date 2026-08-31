<? #4.5.0 ?>
<? $js; $n; ?>

<? include $js['cmd/handlers']; //cmdHandlers, cmdDb ?>

var add_cmd = function(ctx){
    if(0) console.log('add_cmd', { ctx });

    ctx = _.defaults(ctx, {
        id: undefined, //req || $par
        $par: undefined, //req || id

        cmd: undefined, //req

        sv: 'wd-cmd',
        ncPane: '<?=$n?>-cmd',
        ncButton: '<?=$n?>-cmd-button',
        ncPos: '-rb',
        ncPressed: '-pressed',

        activate: {},
    });


    var ncPressed = ctx.ncPressed;
    var sv = ctx.sv;
    var id = ctx.id;
    var $par = ctx.$par ? ctx.$par : $('#' + id);
    //console.log('WD/add_cmd', { $par, has$par: $par.length })


    var $cmdPane = $('<DIV />', {
        'class': [ctx.ncPane, ctx.ncPos].join(' ')
    });

    $cmdPane.appendTo($par);

	<? include $js['add_cmd/add_button']; //addToggleButton() ?>

	_.each(ctx.cmd, function(cmdConf){
        cmdConf = get_cmd_conf(cmdConf);
        //console.log('wd-conf-add-btn', cmdConf, ctx.activate);
        if (ctx.activate[cmdConf.name]) {
            cmdConf.defState = true;
        }
        addToggleButton(cmdConf)
	});

}
