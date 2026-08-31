//0.3.1
function pending_fn(){
    var stack = [];
    var solver = false;
    var solve = function(_this, args){
        solver.apply(_this, args)
    }
    var keep = function(_this, args){
        stack.push([_this, args]);
    }

    var self = function(){
        var args = [].slice.call(arguments);
        solver ? solve(this, args) : keep(this, args)
    }
    var data;
    self.solve = function(fn){
        solver = fn;
        while(data = stack.shift()) {
            solve(data[0], data[1])
        }
    }
    return self;
}