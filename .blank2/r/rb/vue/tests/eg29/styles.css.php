<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
#demo {
    font-family: "Helvetica", Arial, sans-serif;
}
a {
    text-decoration: none;
    color: #f66;
}
li {
    line-height: 1.5em;
    margin-bottom: 20px;
}
.author,
.date {
    font-weight: bold;
}
