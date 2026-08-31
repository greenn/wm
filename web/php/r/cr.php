<? #6-1-15



define('arDir', 'app/r'); //0h
define('arPath', ROOT.'/'.arDir); //1



//application resource
/*
    ar'
    ra''
    rA'
*/
function ar($rName = '', $rOpts = false, $relBase = false){
    /*
        обычно
            $rOpts: R_BASE|R_RELATIVE
            $set: @relBaseDir

    */
    /* * /
    $rArgs = func_num_args() ? func_get_args() : array(false);
    $rOpts = array();
    $rOpts []= array("rBase" => arPath);
    array_splice($rArgs, 1, 0, $rOpts); //вторым аргументом вставляем установку
    $r = call_user_func_array('r', $rArgs);
    /**/

    /* * /
    $rOpts = array("rBase" => arPath);
    if ($relBaseDir) {}
    $r = r($rName, $rOpts, $setOpts);
    /**/

    /* * /
    $preset = array(
        array("rBase" => arPath)
    );
    $rOpts = !$rOpts ? array(): (is_array($rOpts) ? $rOpts : array($rOpts));
    //$set = !$set ? array(): (is_array($set) ? $set : array('relBase' => $set));
    $set = is_string($set) ? array('relBase' => $set): (is_array($set) ? $set : array());
    if (prop($set, 'relBase')) {
        $preset[0]['rBase'] .= '/'.$set['relBase'];
    }
    $rArgs = array_merge($preset, $rOpts);
    array_unshift($rArgs, $rName);
    //d($rArgs);
    $r = call_user_func_array('r', $rArgs);
    /**/



    $rConf = array("rBase" => arPath);
    if (is_string($relBase)) $rConf['relBase'] = $relBase;
    $r = r($rName, $rConf);


    //dx($r, $rName);
    if ($r && $r->rName) {
        $r->initClass();

        if (empty($r->c)) {
            $r->initAutoClass();
        }

    } else {

        //$r = new ohe('<!-- wr -->');
        //$r = new ohe('wr');
        //$r = new ohe("wr '$rName'");
        $r = new ohe("wr($rName)"); //empty-html-object
    }

    return $r;

}





/*
	доступ к веб-рессурсам (web/y)
		например с учётом прав
*/

/*
	доступ к веб-рессурсам (web/r)
*/
define('wrDir', 'web/r'); //0h
define('wrPath', ROOT.'/'.wrDir); //1

function wr($rName = ''){

    $rArgs = func_num_args() ? func_get_args() : array(false);

    $rOpts = array();
    $rOpts []= array("rBase" => wrPath);

    array_splice($rArgs, 1, 0, $rOpts); //вторым аргументом вставляем установку



    $r = call_user_func_array('r', $rArgs);

    //dx($r, $rName);
    if ($r && $r->rName) {

        $r->initClass();

        if (empty($r->c)) {
            $r->initAutoClass();
        }

    } else {

        //$r = new ohe('<!-- wr -->');
        //$r = new ohe('wr');
        //$r = new ohe("wr '$rName'");
        $r = new ohe("wr($rName)"); //empty-html-object
    }

    return $r;

}