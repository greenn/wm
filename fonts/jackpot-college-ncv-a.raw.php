<?#1.2.0(rep)
include_once $_SERVER['DOCUMENT_ROOT'].'/iqq.inc';

_needphp('headers');
headers('css', 'utf8', 'nosniff', etag::ctx(
    __FILE__,
    etag::extra()
), SITE_CACHE); /*#cs1*/
?>

@import url('https://fonts.cdnfonts.com/css/jackport-college-ncv');