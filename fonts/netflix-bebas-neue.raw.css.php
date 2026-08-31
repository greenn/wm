<?#1.2.0(raw)
include_once $_SERVER['DOCUMENT_ROOT'].'/iqq.inc';

_needphp('headers');

$ffTitle = 'Netflix (Bebas Neue)';
$relDir = '/fonts/netflix-bebas-neue';
$fileName = 'Netflix-(Bebas-Neue).ttf';
$format = 'truetype';

headers('css', 'utf8', 'nosniff', etag::ctx(
    __FILE__,
    etag::extra()
), SITE_CACHE); /*#cs1*/
?>

@font-face {
    font-family: '<?=$ffTitle?>';
    src: url('<?="$relDir/$fileName"?>') format('<?=$format?>');
    font-weight: normal;
    font-style: normal;
}