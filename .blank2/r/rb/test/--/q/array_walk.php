<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$sweet = array('a' => 'apple', 'b' => 'banana');
$fruits = array('sweet' => $sweet, 'sour' => 'lemon');

function test_print($item, $key)
{
	echo "$key содержит $item<br>";
}

array_walk_recursive($fruits, 'test_print');