<?
/*
	https://developer.mozilla.org/ru/docs/Web/CSS/CSS_Background_and_Borders/Border-radius_%D0%B3%D0%B5%D0%BD%D0%B5%D1%80%D0%B0%D1%82%D0%BE%D1%80

	td
		10px 5px 2em / 20px 25px 30%
		10px 5% / 20px 25em 30px 35em
		285px 245px 0px 0px / 132px 116px 0px 0px


https://developer.mozilla.org/ru/docs/Web/CSS/border-radius

	 Такой синтаксис позволяет указать всего одно значение, вместе четырёх
	 Скругление применяется ко всем четырём углам
	border-radius: 10px;

	 top-left-and-bottom-right | top-right-and-bottom-left
	border-radius: 10px 5%;

	 top-left | top-right-and-bottom-left | bottom-right
	border-radius: 2px 4px 2px;

	 top-left | top-right | bottom-right | bottom-left
	border-radius: 1px 0 3px 4px;

	 Синтаксис из двух радиусов также может применяться ко всем четырем углам
	 (первые значения радиуса) /радиус
	border-radius: 10px 5% / 20px;

	 (первые значения радиуса) / top-left-and-bottom-right | top-right-and-bottom-left
	border-radius: 10px 5% / 20px 30px;

	 (первые значения радиуса) / top-left | top-right-and-bottom-left | bottom-right
	border-radius: 10px 5px 2em / 20px 25px 30%;

	 (первые значения радиуса) / top-left | top-right | bottom-right | bottom-left
	border-radius: 10px 5% / 20px 25em 30px 35em;


*/
$val = isset($arg[1]) ? $arg[1] : '%s';
if (is_numeric($val)) $val .= 'px';
$vals = is_array($val) ? $val : preg_split('/[\s]+/', $val);

//dx0($val);

//'2px'
//'2px 3px' lt =
//'2px 3px 2px'
//'2px 3px 2px 1px'

$br = array('0px', '', '');
$lt = array('0px', '-top-left', '-topleft');
$rt = array('0px', '-top-right', '-topright');
$rb = array('0px', '-bottom-right', '-bottomright');
$lb = array('0px', '-bottom-left', '-bottomleft');

$r = array();
/* t  r  b  l
  lt rt rb lb

    t   r

    l   b
*/
switch (count($vals)) {
    case 1: {
        $br[0] = $vals[0];
        $r = array($br);
    } break;
    case 2: {
        if (!'combo') {

        } else {
            $lt[0] = $vals[0];
            $rt[0] = $vals[1];
            $rb[0] = $vals[0];
            $lb[0] = $vals[1];
            $r = array($lt, $rt, $rb, $lb);
        }
    } break;
    case 3: {
        $lt[0] = $vals[0];
        $rt[0] = $vals[1];
        $rb[0] = $vals[2];
        $lb[0] = $vals[1];
        $r = array($lt, $rt, $rb, $lb);
    } break;
    case 4: {
        $lt[0] = $vals[0];
        $rt[0] = $vals[1];
        $rb[0] = $vals[2];
        $lb[0] = $vals[3];
        $r = array($lt, $rt, $rb, $lb);
    } break;
}

//dx($vals, $r);
$prefix = array(
    'moz' => '-moz-border-radius%s: %s;',
    'webkit' => '-webkit-border%s-radius: %s;',
    'css3' => 'border%s-radius: %s;',
);
$css = array();
if (!empty($r)) foreach ($prefix as $type => $pattern) {
    $pref_css = array();
    foreach ($r as $index => $set) {
        $value = $set[0]; //prop($set, 'value');
        if (is_array($value)) $value = join(', ', $value);
        $name = $type == 'moz' ? $set[2] : $set[1]; //prop($set, $type);
        $pref_css []= sprintf($pattern, $name, $value);
    }
    $css []= join(' ', $pref_css);
}
print join("\r\n", $css);

//border-radius.com