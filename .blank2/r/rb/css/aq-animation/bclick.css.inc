<?=pcss('keyframes', 'bclick-t', array('100%' => 'top: 2px;' )) //плохо?>
<?//=pcss('keyframes', 'bclick-mt', array('100%' => ' margin-top: 1px;' ))?>
<?=pcss('keyframes', 'bclick-mt', array('100%' => ' margin-top: 2px;' )) //работает но замедленено?>


.bclick-t { position: relative; <?=pcss('animation', '1000ms bclick-t')?> }
.bclick-t[f] { position: fixed; }

.bclick-mt { <?=pcss('animation', '100ms infinite bclick-mt')?> }
.bclick-mt- {
    animation-name: bclick-mt;
    animation-duration: 200ms;
    animation-duration: 1s;
    animation-timing-function: ease-in-out;
    animation-iteration-count: infinite;
}