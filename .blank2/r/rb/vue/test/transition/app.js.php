<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>

vue_app(function(_log){
    return {

        data: function(){
            return {
                slide: true,
                bounce: true,
                animate: true,
            }
        },
        methods: {

        }
    }

}, '#app')