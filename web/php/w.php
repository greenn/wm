<?#0.9.1
/* про слова
    [oo rudic]
    [tt web/test/web/php/w/w.php]
	eg
		<?=w('контейнер', 1)?>; //1 контейнер
    db web/php/w/d/wbc0.data.inc
*/


//использовать слово c модификаторами
function w($name, $case = null, $opt = null){
    $word = $name instanceof word ? $name : wb($name);
    $res = $word;
    if (!is_null($case)) {
        $res = is_numeric($case) ? $word->n($case, $opt) : $word->c($case);
        if ($opt) {
            $res = word::m($res, $opt);
        }
    }
    return $res;
}

/* база конфигов слов
    которые беруться по надобности,
    при создания функциональных объектов для слов

        //https://ru.wiktionary.org/wiki/раз

    wbc('раз', '0:,а,у,,ом,е', '0:ы,,ам,ы,ами,ах', '0:1,>4;0\а:2,3,4');
    //'окончание_1:есть,нет,давать_кому,винить,доволен,думать_о'
*/
function wbc(){
    static $dbc = array();
    switch ($n_args = func_num_args()) {
        case 0: return $dbc;
        case 1: {
            $word = func_get_arg(0);
            return prop($dbc, $word, false);
        }
        default: {
            $word = func_get_arg(0);
            $cfg = array_slice(func_get_args(), 1);

            if ($word === true) { //case: wbc(true, $dbc1, $dbcN) слияние баз-конфигов
                for ($i = 1; $i < $n_args; $i++) {
                    //dx($dbc, $cfg[$i - 1]);
                    $dbc = array_merge($dbc, $cfg[$i - 1]);
                }

            } else {

                $dbc[$word] = $n_args == 1 ? $cfg[0] : $cfg;
                return $word;
            }
        }
    }
}

wbc(true, inc_data(PHP.'/w/d/wbc0.data'));
//dx(wbc());
//function wcb(){}


/* база слов (из сгенерированных словесных-объектов)
    получить слово, если его нет, то занести
*/
function wb($word = null, $forceUpdate = false){
    static $dbw = array();
    if (!func_num_args()) return $dbw;

    if (!isset($dbw[$word]) || $forceUpdate) {
        $config = is_array($forceUpdate) ? $forceUpdate : wbc($word);
        array_unshift($config, $word);
        $Word = new ReflectionClass('word');
        $dbw[$word] = $Word->newInstanceArgs($config);
    }

    return $dbw[$word];
}

//$arr = array()
class wordCase {

    static $order = array( # Иван Рубил Дрова, Варвара Топила Печь
        'nom',  # Именительный, Номанатив                   Есть .. (Кто? Что?)
        'gen',  # Родительный, Генитив                      Нет .. (Кого? Чего?)
        'dat',  # Дательный, Датив                          Давать .. (Кому? Чему?)
        'acc',  # Винительный, Аккузатив, Аблатив           Винить .. (Кого? Что?)
        'ins',  # Тварительный, Локатив, Инстументатив      Доволен/Сотворён .. (Кем? Чем?)
        'pos'   # Предложный, Препозитив                    Думать о .. (О ком? О чём?)
    );
    //варианты имён для падежей
    static $vcases = array(
        'nom' => 'nom',
        'gen' => 'gen',
        'dat' => 'dat',
        'acc' => 'acc',
        'ins' => 'ins',
        'pos' => 'pos',

        'И' => 'nom', 'i' => 'nom',
        'Р' => 'gen', 'r' => 'gen',
        'Д' => 'dat', 'd' => 'dat',
        'В' => 'acc', 'v' => 'acc', //кого, что
        'Т' => 'ins', 't' => 'ins',
        'П' => 'pos', 'p' => 'pos',

        'И+' => 'nom+', 'ii' => 'nom+',
        'Р+' => 'gen+', 'rr' => 'gen+',
        'Д+' => 'dat+', 'dd' => 'dat+',
        'В+' => 'acc+', 'vv' => 'acc+',
        'Т+' => 'ins+', 'tt' => 'ins+',
        'П+' => 'pos+', 'pp' => 'pos+',
    );
    //Падежи для предлогов
    static $pcases = array(
        'в' => 'В', 'вВ' => 'В',  'в+' => 'В+', 'вВ+' => 'В+',
            'вП' => 'П',  'вП+' => 'П+',//Употребляется в сочетании с объектом в винительном или предложном падеже. [ru.wiktionary.org/wiki/в]
        'к' => 'Д',  'к+' => 'Д+'
    );

    static function get($name, $otherwise = null){
        $res = is_null($otherwise) ? $name : $otherwise;
        //if (in_array(self::$order, $res))
        if (isset(self::$pcases[$name])) {
            $name = self::$pcases[$name];
        }
        if (isset(self::$vcases[$name])) {
            $res = self::$vcases[$name];
        }
        return $res;
    }
}

class word {
    var $base;
    var $case = array();
    var $qcase = array();

    function __construct($word, $set1 = false, $setN = false, $setQ = false) {
        $this->base = $word;
        //if (mb_strpos($set1, '¦'))
        if ($set1) $this->setCases($set1);
        if ($setN) $this->setCases($setN, true);
        if ($setQ) $this->setQCases($setQ);
    }


    function c($name) {
        return $this->ncase($name);
    }

    //получить слово в падеже для $name
    function ncase($name){
        $cName = wordCase::get($name);
        return isset($this->case[$cName]) ? $this->case[$cName] : $this->base;
    }

    /* парсинг падежного конфига
        [eg 'раз'
            setCases('0:,а,у,,ом,е')
            setCases('0:ы,,ам,ы,ами,ах', true)
        ]
    */
    private
    function setCases($conf, $plural = false){
        if (is_string($conf)) { //preg_match()
            list($cut, $cases) = explode(':', $conf);
            $base = $cut ? mb_substr($this->base, 0, -$cut) : $this->base;
            foreach (explode(',', $cases) as $index => $case) {
                $caseName = wordCase::$order[$index] . ($plural ? '+' : ''); //nom|nom+
                $caseVal = $base;
                if ($case) {
                    $caseVal = $case[0] == '=' ? mb_substr($case, 1) : $base.$case;
                }
                //d($caseName, $case);
                //echo $caseName, '|', $case, "\r\n";
                $this->case[$caseName] = $caseVal;
            }
        }
    }



    //получить слово с числом в падеже для $name
    function n($n, $pattern = true) {
	    if (!is_string($pattern)) $pattern = $pattern === false? '%2$s' : '%1$s %2$s';
        $case = $this->qcase($n);
        //d($pattern, $n, $case);
        return $pattern ? sprintf($pattern, $n, $case) : $case;
    }

    function qcase($n){
        foreach ($this->qcase as $case => $conds) {
            foreach ($conds as $cond) {
                //d($case, $n, $this->cond_match($n, $cond), $cond);
                if ($this->cond_match($n, $cond)) {
                    return $case;
                }
            }
        }
        return $this->base; //case: ни один из qcase вариантов не подошёл
    }

    /*
        $cond = array(
            array('>' => 2),
            array('<=' => 5)
        );
    */
    private function cond_match($val, $conds) {
        $res = true;
        foreach ($conds as $cond) {
            $sign = $cond[0];
            $def = $cond[1];
            $resCond = false;
            switch ($sign) {
                case '=': $resCond = $val === (int)$def; break;
                case '>=': $resCond = $val >= (int)$def; break;
                case '>': $resCond = $val > (int)$def; break;
                case '<=': $resCond = $val <= (int)$def; break;
                case '<': $resCond = $val < (int)$def; break;
                case 'regex': $resCond = preg_match("~$def~u", $val); break;
                default: {
                    //unkonwn-sign
                }
            }
            //d(array($val, $sign, $def), $res, $resCond, $res * $resCond);
            $res *= $resCond;
        }
        //d($val, $conds, $res);
        return $res;
    }

    /* парсинг количественного конфига
        [eg 'раз'
            setQCases('0:=1,>4;а=2,3,4')
            '0:1,>4;0\а:2,3,4'
            '0:<2>4;0\а:>=2<=4'
            'а:2,3,4'
        ]
    */
    private
    function setQCases($conf){
        if (is_string($conf)) { //preg_match()
            foreach (explode(';', $conf) as $caseConf) {

                list($case, $conds) = explode(':', $caseConf);

                $caseVal = $this->base;
                if ($case) {
                    if ($case[0] == '=') { //case: полная форма слова, начатая со знака ровно "=раза:%conds"
                        $caseVal = mb_substr($case, 1); //форма без знака ровно
                    } else {
                        $cut = false;
                        $add = '';
                        if (mb_strpos($case, '\\')) { //case: слайс от основы слова и добавления окончания
                            list($cut, $add) = explode('\\', $case);
                        } else if (is_numeric($case)) { //case: слайс от конца слова [1:%conds]
                            $cut = $case;
                        } else if (is_string($case)) { //case: добавление окончания [а:%conds]
                            $add = $case;
                        }

                        $caseVal = $cut ? mb_substr($this->base, 0, -$cut) : $this->base;
                        if ($add) $caseVal .= $add;
                    }
                } //else case: ничего не указано ":%conds" ~ caseVal = $this->base;

                $condsVal = array();
                foreach (explode(',', $conds) as $condConf) {

                    $rega_cond = '(([<>=]*)(\d+))'; # https://regex101.com/r/VQsOfj/1/ \ [x '~(([<>=]*)(\d+))[|]?~']
                    $rega_regex = '(\/([^\/]+)\/)'; # https://regex101.com/r/VQsOfj/2/
                    preg_match_all("~$rega_cond|$rega_regex~u", $condConf, $condMatch, PREG_SET_ORDER); # https://regex101.com/r/VQsOfj/5

                    $cond = array();
                    foreach ($condMatch as $match) { //case: >=2<=4 | >20/[234]$/
                        if (isset($match[5])) {
                            $rega = $match[5];
                            $subCond = array('regex', $rega);
                        } else {
                            $sign = $match[2];
                            if ($sign == '') $sign = '=';
                            $def = $match[3];
                            $subCond = array($sign, $def);
                        }
                        $cond [] = $subCond;
                    }

                    $condsVal [] = $cond;
                }

                //dx($caseVal, $condsVal);
                $this->qcase[$caseVal] = $condsVal;
            }
        }
    }


    static function m($string, $modifier){ //u/s/c/f
        $res = false;
        $method = "static::m_".strtolower($modifier);
        if (is_callable($method)) {
            $res = call_user_func($method, $string);
            //dx($method, $res);
        }
        return $res ? $res : $string;
    }

    //все буквы в верхний регистр
    static function m_u($string){
        return mb_strtoupper($string);
    }

    //все буквы в нижний регистр
    static function m_s($string){
        return mb_strtolower($string);
    }

    //все слова с большой буквы
    static function m_c($string){
        return mb_convert_case($string, MB_CASE_TITLE);
    }

    //первое слова с большой буквы
    static function m_f($string){
        $strlen = mb_strlen($string);
        $firstChar = mb_substr($string, 0, 1);
        $rest = mb_substr($string, 1, $strlen - 1);
        return mb_strtoupper($firstChar) . $rest;
    }


    function __get($vName){
        if ($cName = wordCase::get($vName, false)) {
            return $this->ncase($cName);
        }
        return '';
    }

    function __toString(){
        return $this->base;
    }
}
