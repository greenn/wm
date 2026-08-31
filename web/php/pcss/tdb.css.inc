<? # 1-22 Transition for Drawed Borders

    /* eg:
<?=pcss('tdb', array(
    's' => '.rF BUTTON.process',
    'is' => '.-on',
    'bc' => $c1, # border selection color
    'bc_h' => $c2, # border selection color onHover
    'tm' => $toSubmitProcess, # duration of transition ms
    //'o1' => true, # backwards option
))?>
    */

    if (isset($arg[1]) && is_array($arg[1])) extract($arg[1]);
    
    if (!isset($s)) $s = ".tdb"; # selector //.drawBorder|.h5b-sb-2
    if (!isset($sB)) $sB = "$s:before";
    if (!isset($sA)) $sA = "$s:after";

    if (!isset($is)) $is = ":focus"; # init selector
    if (!isset($s_i)) $s_i = "$s{$is}";
    if (!isset($sB_i)) $sB_i = "$s_i:before";
    if (!isset($sA_i)) $sA_i = "$s_i:after";

    if (!isset($bc_h)) $bc_h = false; # change border color onHover
    if (!isset($sB_ih)) $sB_ih = "$s_i:hover:before";
    if (!isset($sA_ih)) $sA_ih = "$s_i:hover:after";


    if (!isset($bc)) $bc = 'black';
    if (!isset($tm)) $tm = 800; # duration of transition ms
    if (!isset($bw)) $bw = 1;
    if (!isset($o1)) $o1 = true; # backwards option
    
   
    $d = floor($tm / 4);
	$dp = array(0, $d, $d * 2, $d * 3, $d);
?>

<?=$s?> {
    position: relative;
}
<?=$sB?>,
<?=$sA?> {
    content: '';
    position: absolute;
    width: 0;
    height: 0;
    opacity: 0;
    box-sizing: border-box;
    border-style: solid;
    border-color: <?=$bc?>;
    border-width: 0;
}

<? if ($bc_h) { ?>
    <?="$sB_ih"?>,
    <?="$sA_ih"?> {
        border-color: <?=$bc_h?>;
    }
<? } ?>

<?=$sB?> {
    bottom: 0;
    left: 0;
    border-left-width: <?=$bw?>px;
    border-top-width: <?=$bw?>px;
    <?= pcss_if($o1, 'transition', array(
        "{$dp[0]}ms ease opacity {$dp[4]}ms",
        "{$dp[1]}ms ease width {$dp[2]}ms",
        "{$dp[1]}ms ease height {$dp[3]}ms",
    )) ?>
}
<?=$sA?> {
    top: 0;
    right: 0;
    border-right-width: <?=$bw?>px;
    border-bottom-width: <?=$bw?>px;
    <?= pcss_if($o1,'transition', array(
        "{$dp[0]}ms ease opacity {$dp[2]}ms",
        "{$dp[1]}ms ease width",
        "{$dp[1]}ms ease height {$dp[1]}ms",
    )) ?>
}
<?=$sB_i?>,
<?=$sA_i?> {
    height: 100%;
    width: 100%;
    opacity: 1;
}
<?=$sB_i?> {
    <?= pcss('transition', array(
        "{$dp[0]}ms ease opacity {$dp[0]}ms",
        "{$dp[1]}ms ease height",
        "{$dp[1]}ms ease width {$dp[1]}ms",
    )) ?>
}
<?=$sA_i?> {
    <?= pcss('transition', array(
        "{$dp[0]}ms ease opacity {$dp[2]}ms",
        "{$dp[1]}ms ease height {$dp[2]}ms",
        "{$dp[1]}ms ease width {$dp[3]}ms",
    )) ?>
}

<?/*=pcss('keyframes', 'start-button', array(
      '100%' => array('width' => '100%', 'height' => '100%', 'opacity' => 1)
))*/?>