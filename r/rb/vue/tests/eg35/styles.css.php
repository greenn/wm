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

.list-complete-item {
    transition: all 0.8s ease;
    display: inline-block;
    margin-right: 10px;
}

.list-complete-enter-from,
.list-complete-leave-to {
    opacity: 0;
    transform: translateY(30px);
}

.list-complete-leave-active {
    position: absolute;
}