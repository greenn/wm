переделать
linear-gradient в linear-gradient--bg
а linear-gradient сделать простым


$grad = join(', ', array(
   'rgb(113, 255, 54)', //yellow
   'cyan',
));

background: -webkit-linear-gradient(left, <?=$grad?>);
background: -o-linear-gradient(right, <?=$grad?>);
background: -moz-linear-gradient(right, <?=$grad?>);
background: linear-gradient(to right, <?=$grad?>);
