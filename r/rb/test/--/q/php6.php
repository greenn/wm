<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


$input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
$rand_keys = array_rand($input, 2);
echo $input[$rand_keys[0]] . "\n";
echo $input[$rand_keys[1]] . "\n";
d(array_rand($input, 1  ));
dx($input[array_rand($input)]);
