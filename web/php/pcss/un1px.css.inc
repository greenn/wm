<?#2.7.1
_needphp('img/l/di');
_needphp('isAssoc'); //isOrdinal

$fs = isset($arg[1]) ? $arg[1] : '%s'; //font-size
$c = isset($arg[2]) ? $arg[2] : '%s'; //color
$fp = isset($arg[3]) ? $arg[3] : 0; //font-padding: space between font base-line and color-line
$pl = isset($arg[4]) ? $arg[4] : 0; //left shift for start background-repeating
if ($c === 'dash') $c = array();
if (is_array($c)) { //underline config: dash
    //i64_dash: 6: $dashColor, $bgColor, $wDash, $wSpace, $height, $posDash
    //gdi_dash: 6: 'hexDashColor', 'hexBgColor',  'dash_width', 'dash_space', 'height',  'dash_start'
    $dataImage = isOrdinal($c)
        ? call_user_func_array('i64_dash', $c)
        : gdi_dash($c);
} else { //underline solid 1px
    $dataImage = i64_1px($c);
}
$pt = x('un1px_pt', $fs + $fp); //background top position
x('un1px_w', is_array($c) ? x('gi_dash_w') : 1); //background image width
/*
    [eg web/test/web/css/pcss/un1px.php]
    [va
        https://stackoverflow.com/questions/13840403/edit-line-thickness-of-css-underline-attibute#28703456
        box-shadow: inset 0 0px 0 white, inset 0 -1px 0 black
    ]
*/
?>
background: url('<?=$dataImage?>') repeat-x <?=$pl?>px <?=$pt?>px;
<?/*

<?=pcss('un1px', $fs, array($c, 'transparent', 3, 1, 1), 1, -1) //dash, space, height ~ underFont, leftStart?>

*/?>