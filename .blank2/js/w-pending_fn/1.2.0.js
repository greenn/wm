//0.2.1
function pending_fn(){
    var stack = [];
    var self = function(){
        var args = [].slice.call(arguments);
        stack.push(args);
    }
    self.stack = stack;
    self.applyWith = function(fn, _this){
        if (!_this) _this = null;
        if (fn) for (var i = 0; i < stack.length; i++) {
            //console.log('pended', stack[i]);
            fn.apply(null, stack[i]);
        }
    }
    return self;
}