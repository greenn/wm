<?  //http://the-echoplex.net/flexyboxes
    //[rm display]
    $inline = isset($arg[1]) ? $arg[1] === 'inline' : false;
    /*
        pcss('display-flex', 'flex'); //'box'
        pcss('display-flex', 'inline');
        pcss('display-flex');
    */
?>
display: -webkit-box;
display: -moz-box;
display: <?=$inline ? '-ms-inline-flexbox': '-ms-flexbox'?>;
display: <?=$inline ? '-webkit-inline-flex': '-webkit-flex'?>;
display: <?=$inline ? 'inline-flex': 'flex'?>;