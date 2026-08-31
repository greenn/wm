//dd
self.setNode = function(node, type){
    nc('setNode', type, node);
    self.$ = $(node);
}
self.setNode.for = function(type){
    return function(node){
        self.setNode(node, type);
    }
}


self.modeTpl = ko.observable();
self.setMode = function(name, ctx){
    var tplName = tn(name);
    if (!ctx) ctx = self;
    else ctx.self = self;
    self.modeTpl({ name: tplName, data: ctx })
}

self.backList = function(){
    self.setMode('list');
}