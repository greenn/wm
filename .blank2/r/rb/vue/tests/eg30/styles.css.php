<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
body {
    font-family: Helvetica Neue, Arial, sans-serif;
}

polygon {
    fill: #42b983;
    opacity: 0.75;
}

circle {
    fill: transparent;
    stroke: #999;
}

text {
    font-family: Helvetica Neue, Arial, sans-serif;
    font-size: 10px;
    fill: #666;
}

label {
    display: inline-block;
    margin-left: 10px;
    width: 20px;
}

#raw {
    position: absolute;
    top: 0;
    left: 300px;
}
