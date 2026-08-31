<?#3.3.13  Transition for Dynamic Striped BackGround
    _needphp('incr');
/*
<?=pcss('tdsbg', array(
    's' => '.rF .field.process',
    'is' => '.-on',
    'sc1' => $bF
))?>
    */
    $N = incr('pcss-tdsbg');

    if (isset($arg[1]) && is_array($arg[1])) extract($arg[1]);
    
    if (!isset($s)) $s = ".tdsbg"; # selector //.dynamicStripes
    if (!isset($is)) $is = ":focus"; # init selector
    if (!isset($s_i)) $s_i = "$s{$is}";


    if (!isset($sc)) { //stripes config
        if (!isset($sc1)) $sc1 = 'rgba(30, 255, 188, 1)';
        if (!isset($sc2)) $sc2 = 'rgba(255, 255, 255, 1)';
        if (!isset($sdir)) $sdir = '-45deg';
        $sc = array(
			"$sdir",
			"$sc1 25%",
			"$sc2 25%", "$sc2 50%",
			"$sc1 50%", "$sc1 75%",
			"$sc2 75%", "$sc2",
		);
    };

     if (!isset($bgs)) $bgs = 10; // background-size
     if (!isset($stm)) $stm = 750; # time of stripes moving
     if (!isset($s_to)) $s_to = 500; # transition timeout for stripes [ps не участвует, так как анимация идёт через animation с $stm]
     if (!isset($sk)) $sk = 5; # times of passed background size for transition timeout
     $sdis = $bgs * $sk; # distance of dynamic stripes

     if (!isset($c)) $c = false;
     if ($c && isset($ci) && $ci) $c = "$c !important";
     if (!isset($c_to)) $c_to = 300; # transition timeout for color


     if (!isset($t_add)) $t_add = false; # add transitions to this selector

     if (!isset($ak_add_from)) $ak_add_from = null; # add animations to keyframes
     if (!isset($ak_add_to)) $ak_add_to = null; # add animations to keyframes

     //var_dump($c); exit;
?>

<?=$s_i?> {
    <?=pcss(array(
        'color' => $c ? $c : '',
        'animation' => "stripes-move-$N {$stm}ms infinite linear",
        'linear-gradient' => $sc,
        'background-size' => "{$bgs}px {$bgs}px"
    ))?>
    <?=pcss('transition', array(
       $c ? "color {$c_to}ms" : '',
       "background {$s_to}ms",
       $t_add
   ))?>
}
<?=pcss('keyframes', "stripes-move-$N", array(
      '0%' => array(
          'background-position: 0 0',
          $ak_add_from
      ),
      '100%' => array(
          "background-position: {$sdis}px 0",
          $ak_add_to
      ),
))?>