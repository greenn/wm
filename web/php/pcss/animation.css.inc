<? $val = isset($arg[1]) ? $arg[1] : '%s';
if (is_array($val)) $val = join(', ', $val);
?>
-webkit-animation: <?=$val?>; <?# Chrome < 43.0, Safari < 4.0?>
-moz-animation: <?=$val?>; <?# 5.0 >< 16.0?>
-o-animation: <?=$val?>; <?# 4.0 >< 12.10?>
animation: <?=$val?>;
<?/*
animation:

name
duration
timing-function
delay
iteration-count
direction
fill-mode
play-state;
timeline

3s ease-in 1s 2 reverse both paused slidein

3s          duration
ease-in     timing-function
1s          delay
2           iteration-count
reverse     direction
both        fill-mode
paused      play-state
slidein     name

<?=pcss('animation', '200ms infinite bclick-t')?>

*/?>