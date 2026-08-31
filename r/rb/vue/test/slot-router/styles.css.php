<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
$nCS = $Self::nc('cmpt-slot');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

MAIN {
    border: 1px solid darkmagenta;
}
SECTION {
    height: 80px;
    margin: 10px;
    padding: 10px;
    border-style: double;
    border-width: 3px;
    border-color: dimgrey;
}

SECTION[red] {
	border-color: darkred;
}

SECTION[green] {
    border-color: darkgreen;
}

SECTION[blue] {
    border-color: darkblue;
}
