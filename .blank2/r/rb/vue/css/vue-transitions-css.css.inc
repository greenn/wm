<?
$Self;

$_styles = array();
foreach (dirToArray::apply(array(
	'path' => $Self::path('css/vue-transitions-css'),
	'keepDots' => false,
	'depth' => 1,
)) as $name => $path) {
    $_styles []= file_get_contents($path);
}
print "/*vue-transitions-css*/\n";
print join("\n", $_styles);