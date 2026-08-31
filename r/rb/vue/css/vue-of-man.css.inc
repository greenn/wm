<?
$Self;

print "/*vue-of-man*/\n";

foreach (dirToArray::apply(array(
	'path' => $Self::path('css/vue-of-man'),
	'keepDots' => false,
	'depth' => 1,
)) as $name => $path) {
	include $path;
}