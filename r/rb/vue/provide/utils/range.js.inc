_vue.provider.range = function(max){
    return Array.from({ length: max }, (_, i) => i + 1);
}

//ES5 version
_vue.provider.makeRange = function(max) {
    var result = [];
    for (var i = 1; i <= max; i++) {
        result.push(i);
    }
    return result;
}