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
    margin: 30px;
}

button {
    margin-right: 10px;
}

.list-item {
    display: inline-block;
    margin-right: 10px;
}

.list-enter-active,
.list-leave-active {
    transition: all 1s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(30px);
}