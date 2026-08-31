<?

_needphp('webinc', 'webreq', 'w');
_needphp('json/jsonEncode');

$wbc = array();
$wbc[':case'] = wordCase::$order;
$wbc[':vcase'] = wordCase::$vcases;
$wbc[':pcase'] = wordCase::$pcases;
foreach (wbc() as $word => $conf) {
    $Word = wb($word, $conf);
    $wbc[$word] = array(
        'ncase' => $Word->case,
        'qcase' => $Word->qcase,
    );
}
//exit;
$jsObject = jsonEncode($wbc);
//dx($wbc, $jsObject, json_last_error(), json_last_error_msg());

if(0) if (!$jsObject) {
    function cb_htmlentities(&$value){
        $value = htmlentities($value);
    }
    array_walk_recursive($wbc, 'cb_htmlentities');
    $jsObject = jsonEncode($wbc);
    //dx($wbc, json_last_error(), json_last_error_msg());
}

if(1) if (!$jsObject) {
    $genPath = dirname(__FILE__).'/gen/w.json.inc';
    return include $genPath;
}

?>

_wbc = <?=$jsObject ? $jsObject : '{}'?>; //_wbc|$wbc|
_wbc.get = function(name, otherwise){
    if (typeof otherwise == 'undefined') otherwise = name;
    if (_wbc[':pcase'][name]) name = _wbc[':pcase'][name];
    return _wbc[':vcase'][name] || otherwise;
}

function _w(word, mode, mdf, opt){ //opt = pattern для mode:number
    var res = word;
    var Word = _wbc[word];
    //c(Word, mode, typeof mode == 'number');
    if (Word && typeof mode !== 'undefined') {
        if (typeof mode == 'number') {
            res = _w.match_qcase(Word.qcase, mode) || word;
            var pattern = typeof opt == 'string' ? opt : (opt !== false ? '%n %w' : false);
            if (pattern) {
                res = pattern.replace('%n', mode).replace('%w', res);
            }
        } else {
            var cName = _wbc.get(mode);
            res = Word.ncase[cName];
        }
    }
    switch (mdf) {
        //все буквы в верхний регистр
        case 'u': res = res.toUpperCase(); break;
        //все буквы в нижний регистр
        case 's': res = res.toLowerCase(); break;
        //все слова с большой буквы
        case 'c': res = res.replace(/\S+/g, function(str){
            return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
        }); break;
        //первое слова с большой буквы
        case 'f': res = res.charAt(0).toUpperCase() + res.slice(1); break;
    }
    return res;
}
_w.match_qcase = function(cases, val){
    for (var _case in cases) {
        var conds = cases[_case];
        for (var i in conds) {
            var cond = conds[i];
            if (_w.match_qcond(cond, val)) {
                return _case;
            }
        }
    }
    return false;
}
_w.match_qcond = function(conds, val){
    var res = true;
    for (var i in conds) {
        var cond = conds[i];
        var sign = cond[0];
        var def = cond[1];
        var resCond = false;
        //c(mode, sign, def);
        switch (sign) {
            case '=': resCond = val === parseInt(def); break;
            case '>=': resCond = val >= parseInt(def); break;
            case '>': resCond = val > parseInt(def); break;
            case '<=': resCond = val <= parseInt(def); break;
            case '<': resCond = val < parseInt(def); break;
            case 'regex': resCond = (new RegExp(def)).test(val); break;
        }
        res *= resCond;
    }
    return res;
}