<?//oo css/cored/cored.css.struct
$Self;

foreach (array(
    //'an',
    'ao',
    'bclick',
    'blink',
    'shake-404',
    'flip',
    'spin',
    'moveUpDown',
) as $name) {
 	include $Self::path("aq-animation/$name.css.inc");
}
