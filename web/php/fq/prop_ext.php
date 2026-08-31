<? //1.0d
//[tt] //0
_addphp('fq/_is'); //is_mixed
_needphp('set');
function prop_ext($base, $val, $set = false) {
    $res = false;
    if (not_set($set)) {
        $hasPar = is_mixed($set);
        $set = set(
            'par', $hasPar ? $set : false,
            'replace', $hasPar ? func_get_arg(3) : $set
        );
    }

    if ($asParProp = is_string($base) && $set->par) {
        $base = is_object($set->par) ? $set->par->{$base} : $set->par[$base];
    }
    if (is_object($base)) $base = (array) $base;
    if (!is_array($base)) $base = array();

    if (is_object($val)) $val = (array) $val;
    if (is_array($val)) {
        $res = $set->replace ? array_replace($base, $val) : array_merge($base, $val);
    }

    if (!$res) $res = array();

    return $asParProp
        ? (is_object($set->par)
            ? ($set->par->{$base} = $res)
            : ($set->par[$base] = $res)
        ) : $res
    ;
}