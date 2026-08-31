<?
$c = isset($arg[1]) ? $arg[1] : '%s';
?>
<?/*-background-image: url(bg-image.png); */?>
-webkit-background-size: <?=$c?>; <?# Safari 3.0 ?>
-moz-background-size: <?=$c?>; <?# Gecko 1.9.2 (Firefox 3.6) ?>
-o-background-size: <?=$c?>; <?# Opera 9.5 ?>
background-size: <?=$c?>; <?# Gecko 2.0 (Firefox 4.0) and other CSS3-compliant browsers ?>
<?/*-moz-border-image: url(bg-image.png) 0;    $ Gecko 1.9.1 (Firefox 3.5) */?>
<?/* if ($ie) { ?>-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='path_relative_to_the_HTML_file', sizingMethod='scale')"<? } ?> <? # IE8 */?>
<?/*

https://developer.mozilla.org/ru/docs/Web/CSS/background-size




*/?>