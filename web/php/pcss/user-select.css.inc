<?
    $val = isset($arg[1]) ? $arg[1] : '%s';

    /*
        pcss_etag_ctx('user-select'),
        <?=pcss('user-select', 'none')?>
    */
    //return '';
?>
-webkit-touch-callout: <?=$val?>; <?# iOS Safari ?>
-webkit-user-select: <?=$val?>; <?# Safari ?>
-khtml-user-select: <?=$val?>; <?# Konqueror HTML ?>
-moz-user-select: <?=$val?>; <?# Firefox ?>
-ms-user-select: <?=$val?>; <?# Internet Explorer/Edge ?>
user-select: <?=$val?>; <?# Chrome and Opera ?>