<? $arg;
_needphp('incr');
_needphp('useTemplate');
/*

	5 - $r->logName
*/

$n = $arg[1]; //''
$rv = $arg[2]; //'_'

$nc_cs = reduce_min_indent( prop($arg, 3, 'false') );
$nameAccess = reduce_min_indent( prop($arg, 4, 'false') );
$nc_sn = (has_prop($arg, 5) && is_stringable($arg[5])) ? valToStr($arg[5]) : 'sn'; //nc startName [sn = $n]

$suffix = has_prop($arg, 6) ? $arg[6] : false; //nameSuffix
if (!is_stringable($suffix)) $suffix = !$suffix ? '' : incr('gjs-rc');



//reduce_min_indent(1)
$path = gjs_path($arg[0], true);
$snippet = useTemplate($path, array(
    'n' => $n,
    'rv' => $rv,
    'nc_cs' => $nc_cs,
    'nameAccess' => $nameAccess,
    'nc_sn' => $nc_sn,
    'incr' => incr(null, 'gjs-rc'),
));
if ($suffix) {
    //$vars_left = array('sn', 'cn', 'vn', 'tn', 'nc');
    $vars = array('._sn', '._cn', '._vn', '._tn', '._nc');
    $changes = array();
    foreach ($vars as $name) {
        $changes[$name] = $name.$suffix;
    }
    $snippet = gjs_replace($snippet, $changes);
}

//print "\r\n".$snippet;
print $snippet;

/* eg
<?=gjs('rc', $n, $rv, "['Z', 'Z-Ss']", "{
    ':': 0, //
    'ext': 0, //
    'init': 0, //
}")?>
*/