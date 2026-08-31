<?
$pos = 'relative';
$top = '50%';
$y = '-50%';
if (isset($arg[1])) {
    if ($arg[1] === true || $arg[1] === 'absolute') {
        $pos = 'absolute';
    }
}
if (isset($arg[2])) $top = $arg[2];
if (isset($arg[3])) $y = $arg[3];
?>
position: <?=$pos?>;
top: <?=$top?>;
<?=pcss('transform', "translateY($y)")?>