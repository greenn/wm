<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//https://stackoverflow.com/questions/3665247/fastest-hash-for-non-cryptographic-uses

$loops = 100000;
$str = "ana are mere";

//crc32(), md5()

echo "<pre>";

$tss = microtime(true);
for($i=0; $i<$loops; $i++){
	$x = crc32($str);
}
$tse = microtime(true);
echo "\ncrc32: \t" . round($tse-$tss, 5) . " \t" . $x;

$tss = microtime(true);
for($i=0; $i<$loops; $i++){
	$x = md5($str);
}
$tse = microtime(true);
echo "\nmd5: \t".round($tse-$tss, 5) . " \t" . $x;

$tss = microtime(true);
for($i=0; $i<$loops; $i++){
	$x = sha1($str);
}
$tse = microtime(true);
echo "\nsha1: \t".round($tse-$tss, 5) . " \t" . $x;

$tss = microtime(true);
for($i=0; $i<$loops; $i++){
	$l = strlen($str);
	$x = 0x77;
	for($j=0;$j<$l;$j++){
		$x = $x xor ord($str[$j]);
	}
}
$tse = microtime(true);
echo "\nxor: \t".round($tse-$tss, 5) . " \t" . $x;

$tss = microtime(true);
for($i=0; $i<$loops; $i++){
	$l = strlen($str);
	$x = 0x08;
	for($j=0;$j<$l;$j++){
		$x = ($x<<2) xor $str[$j];
	}
}
$tse = microtime(true);
echo "\nxor2: \t".round($tse-$tss, 5) . " \t" . $x;

$tss = microtime(true);
for($i=0; $i<$loops; $i++){
	$l = strlen($str);
	$x = 0;
	for($j=0;$j<$l;$j++){
		$x = $x + ord($str[$j]);
	}
}
$tse = microtime(true);
echo "\nadd: \t".round($tse-$tss, 5) . " \t" . $x;