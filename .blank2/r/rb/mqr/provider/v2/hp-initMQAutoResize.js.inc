//self;

var parseAttrPairs = function(as){
    var pairs = _.map(_.split(as, ';'), function(pair) {
        var [key, value] = _.split(pair, '=');
        return [_.trim(key), self.convertStringToTypedValue(value)];
    });
    return _.fromPairs(pairs); //создаём объект из пар
}


var get_mqr = function($node){
    var mqr = $node.attr('mqr');
    var mqrChunks = _.split(mqr, ',');
    var mqrVals = _.map(mqrChunks, function(item, index) {
        //_log('mqrVals/do', { item, arguments })
        //return _.trim(item); if (index === 2) return _.trim(item);
        return self.convertStringToTypedValue(item);
        //return parseInt(_.trim(item), 10); // Второй аргумент в parseInt указывает на систему счисления (10 для десятичной)
    });
    var opts = _.zipObject(['w', 'h', 'dbg'], mqrVals);

    if (!opts.w) {
        if (__cfg.getDefWidth) {
            opts.w = __cfg.getDefWidth($node);
        }
        if (!opts.w) opts.w = __cfg['site-w']; //1280|1300
        if (!opts.w) opts.w = <?=css('site-w')?>; //1280|1300
    }
    if ($node.is("[mqrd]")) opts.dbg = $node.attr("[mqrd]") !== 'off';

    return opts;
}

var verifyNestedMqr = function($node){
    var $_childs = $('[mqr]', $node)
    if ($_childs.length) {
        _log('mqr-has-child', {
            $node, node: $node[0],
            $_childs, q$_childs: $_childs.length,
            $_child1: $_childs[0]
        });
        return false;
    }
    return true;
}


var get_mqrc = function($node){
    //ak mqr-cfg \ prev -css
    var mqrc = $node.attr('mqrc');
    if (mqrc) {
        mqrc = parseAttrPairs(mqrc)
    }
    return mqrc || {};
}


var get_mqrs = function($node){
    var mqrs = $node.attr('mqrs');
    if (mqrs) {
        var mqrsPairs = _.map(_.split(mqrs, ';'), function(pair) {
            var [opt, optValue] = _.split(pair, '=');
            //optValue = '800:10vw,500:10';
            var valuePairs = _.map(_.split(optValue, ','), function(pair) {
                var [mqVal, value] = _.split(pair, ':');
                //value=5vw | value=10
                return [mqVal, self.splitValueAndUnit(value)];
            });

            return [_.trim(opt), _.fromPairs(valuePairs)];
        });
        mqrs = _.fromPairs(mqrsPairs); //создаём объект из пар
    }
    return mqrs;
}

var get_mqrw = function($node){
    var mqrw = $node.attr('mqrw');

    if (mqrw) {
        mqrw = parseAttrPairs(mqrw)
    }
    //console.log('mqrw init', mqrw);
    return mqrw;
}

var get_mqrk = function($node){
    var mqrk = $node.attr('mqrk');
    return mqrk;
}



var get_mqrz = function($node){
    var mqrz = $node.attr('mqrz');
    if (mqrz) {
        if (!self.isNumeric(mqrz)) { //case: as sr
            mqrz = $(mqrz, $node).css('z-index');
        }
    } else {
        mqrz = $node.css('z-index');
    }
    return mqrz;

}

var get_mqrh = function($node){
    var mqrh = $node.attr('mqrh');
    if (mqrh) {
        mqrh = parseAttrPairs(mqrh)
        //_log('mqrh', { mqrh })
    }
    return mqrh;
}

var get_mqrl = function($node){
    var mqrl = $node.attr('mqrl');
    if (mqrl) {
        mqrl = parseAttrPairs(mqrl)
        //_log('mqrl', { mqrl })
    }
    return mqrl;
}