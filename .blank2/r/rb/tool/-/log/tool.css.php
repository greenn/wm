<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php';
_needphp('headers');

$Self = _rw::name('tool-log');
$nAp = $Self::nc('app');
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));

?>
@import url('https://fonts.googleapis.com/css2?family=Fira+Code&display=swap');
BODY {
    font-family: 'Fira Code', monospace;
}
H1 { color: red }

[time] {
    font-size: 14px;
}
[time="passed"] {
    font-style: italic;
    font-size: 14px;
}

[time="start"] {
    font-size: 12px;
    margin-left: 10px;
}
    [time="start"]:before { content: '['; }
    [time="start"]:after { content: ']'; }
