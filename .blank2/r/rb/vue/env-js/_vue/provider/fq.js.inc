Provider.isNumeric = function(str) {
    return !isNaN(str) && !isNaN(parseFloat(str));
};

//gpt - не проверял
Provider.isNumber = function(str) {
    return _.isFinite(_.toNumber(str));
};
/* jquery
    isNumeric: function(a) {
        var b = a && a.toString();
        return !n.isArray(a) && b - parseFloat(b) + 1 >= 0
    },
*/

Provider.splitValueAndUnit = function(str){
    if (typeof str === 'number') {
        return [str, 'px']
    }
    var match = str.match(/^(\d+)(\w+)$/);
    return match ? [match[1], match[2]] : [str, 'px'];
}

ProviderDep.convertStringToTypedValue = ['isNumeric'];
Provider.convertStringToTypedValue = function(str){
    if (str === 'true') return true;
    if (str === 'false') return false;
    if (str === 'null') return null;
    if (this.isNumeric(str)) return parseInt(str);
    return str;
}