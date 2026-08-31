<?
/*

*/
$val = isset($arg[1]) ? $arg[1] : '%s';

if (is_array($val)) $val = join(',', $val);


$css3 = isset($arg[2]) && is_string($arg[2]) ? $arg[2] : $val;
$ie = isset($arg[3]) ? $arg[3] : false;
$webkit = isset($arg[4]) ? $arg[4] : false;

$regex_match_deg = '~(-?[\d]+)deg~';
if (!is_callable('_deg_translate')) {
    function _deg_translate($matched) {
        return (((integer)$matched[1] + 90) % 360) . 'deg';
    }
}

if ($val == $css3) {
    $_parts = explode(',', $css3); //$color-stops
    foreach ($_parts as &$part) {
        $part = strtr(trim($part), array(
            'to top' => 'to top',
            'to right' => 'to right',
            'to bottom' => 'to bottom',
            'to left' => 'to left',

            'bottom' => 'to top',
            'bottom left' => 'to top right',
            'left bottom' => 'to right top',
            'left' => 'to right',
            'top left' => 'to bottom right',
            'left top' => 'to right bottom',
            'top' => 'to bottom',
            'top right' => 'to bottom left',
            'right top' => 'to left bottom',
            'right' => 'to left',
            'right bottom' => 'to left top',
            'bottom right' => 'to top left'
        ));
    }
    $css3 = join(',', array_values($_parts));


    $css3 = preg_replace_callback($regex_match_deg, '_deg_translate', $css3);
}





?>
<? if ($webkit) { ?>background-image: -webkit-gradient(<?=$webkit?>); <? } ?> <? # safari4+, chrome, Webkit (Safari/Chrome 10) ?>
background-image: -moz-linear-gradient(<?=$val?>); <? # FF3.6-15 ?>
background-image: -webkit-linear-gradient(<?=$val?>); <? # Chrome10-25, Safari5.1-6, Android 2.3 ?>
background-image: -o-linear-gradient(<?=$val?>); <? # opera 11.10+ ?>
background-image: -ms-linear-gradient(<?=$val?>); <? # ie10+ ?>
background-image: linear-gradient(<?=$css3?>); <? # W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ ?>
<? if ($ie) { ?>filter: progid:DXImageTransform.Microsoft.gradient(<?=$ie?>);<? } ?> <? # IE6-9 ?>
<?/*
//IE8- CSS hack
@media \0screen\,screen\9 {
    .gradient {
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff000000",endColorstr="#00000000",GradientType=0);
    }
}


https://www.sitepoint.com/building-linear-gradient-mixin-sass/

-   -   -   -
//http://angrytools.com/gradient/
//var angle = Math.round(Math.asin(b) * (180/Math.PI));

-   -   -   -
https://github.com/thoughtbot/bourbon/issues/520

https://github.com/postcss/autoprefixer/issues/589
.foo {
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#eeeeee));
    background-image: -webkit-linear-gradient(top, #f8f8f8, #eeeeee);
    background-image: -moz-linear-gradient(top, #f8f8f8, #eeeeee);
    background-image: -o-linear-gradient(top, #f8f8f8, #eeeeee);
    background-image: linear-gradient(to bottom, #f8f8f8, #eeeeee);
}

background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 30%, rgba(255,255,255,0) 100%);
background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 30%,rgba(255,255,255,0) 100%);
background: linear-gradient(to right, rgba(255,255,255,1) 0%,rgba(255,255,255,1) 30%,rgba(255,255,255,0) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#00ffffff',GradientType=1 );



*/
