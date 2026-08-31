<?#5.4 [jz/oo fq/undefined]

//define('undefined', 'undefined');

function undef() {
    return new undefinedValue;
}
function isUndef($value) {
    return $value instanceof undefinedValue;
}
function isDef($value){
    return !isUndef($value);
}

class undefinedValue {
    function __toString() {
        return 'undefined';
    }
}

/*
function log($dataName, $dataValue = undefined){
    if (undef($dataValue));
}
*/