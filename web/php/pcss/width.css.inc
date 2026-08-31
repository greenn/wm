<? $arg;
    $val = isset($arg[1]) ? $arg[1] : '%s';

    //http://the-echoplex.net/flexyboxes
?>
<?if ($val === 'min-content') { ?>
width: min-intrinsic;       /* old Chrome, Safari */
width: -webkit-min-content; /* less old Chrome, Safari */
width: -moz-min-content;    /* current Firefox */
width: min-content;         /* current Chrome, Safari; not IE or Edge */
<? } else { ?>
width: <?=$val?>;
<? } ?>