<? /*
    < add_cmd()
        $cmdPane
        ctx
        $par
        ncPressed
*/?>

var addToggleButton = function(cmd){
    cmd = _.defaults(cmd, {
        name: undefined, //req
        defState: undefined, //
        //methodType: 'toggle',
        buttonText: cmd.name, // /[нажато, отжато]
        buttonTitle: cmd.name,
        //resetState: false,
    });

    var $button;
    var cmdName = cmd.name;
    //var methodType = cmd.methodType;1
    var method = cmd.method;
    var state = _storage.get([sv, id, cmdName, 'state']) || cmd.defState;
    //if (cmd.resetState) state = cmd.defState;
    ///console.log('initState', { 'sdPath': [sv, id, cmdName, 'state'], state: state, ctx: cmd });


    var self = typeof cmd.self === 'function' ? cmd.self(cmd) : cmd.self || {};
    self.$par = $par;
    var selfObj = function(){
        self.state = state
        return self;
    }

    /*var isPressed = cmd.isPressed || function(state){
        return !!state;
    }*/

    var applyMethod = function(){
        method.call(selfObj(), state);
    }

    var changeableTitle = false;
    var setTitle = function(title){
        $button.attr('title', title);
    }
    var applyTitle = function(){
        var newTitle;
        if (typeof cmd.buttonTitle == 'object') { //case: isArray
            newTitle = cmd.buttonTitle[state ? 0 : 1];
        } else if (typeof cmd.buttonTitle == 'function') { //case: isFunction
            newTitle = cmd.buttonTitle(state);
        }
        if (typeof newTitle == 'string') {
            setTitle(newTitle);
        }
    }

    var applyState = function(){
        $button[state ? 'addClass' : 'removeClass'](ncPressed);
        changeableTitle && applyTitle();
        applyMethod();
        _storage.save([sv, id, cmdName, 'state'], state)
    }

    var toggleClick = function(){
        //if (methodType === 'toggle');
        console.log('WD/toggleClick');
        state = !state;
        applyState();
    }

    $button = $('<BUTTON />', {
        attr: {
            'cmd': cmdName,
        },
        'class': ctx.ncButton,
        text: cmd.buttonText,
        //title: cmd.buttonTitle, //~> applyTitle()
        click: toggleClick
    });
    if (typeof cmd.buttonTitle == 'string' || typeof cmd.buttonTitle == 'number') {
        setTitle(cmd.buttonTitle);
    } else if (typeof cmd.buttonTitle == 'object' || typeof cmd.buttonTitle == 'function') {
        changeableTitle = true;
    }

    self.$button = $button;

    //$button.data('wd-cmd', )

    $button.appendTo($cmdPane);
    if(0) console.log('WD/add_button', {
        $button: $button,
        has$button: $button.length,
    })
    applyState();

}