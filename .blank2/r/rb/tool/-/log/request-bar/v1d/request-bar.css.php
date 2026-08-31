<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php';
_needphp('headers', 'pcss');

$Self = _rw::name('tool-log');
$nRB = $Self::nc('request-bar');
$tr = css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(__FILE__));
?>
.<?=$nRB?> {
    height: 5px;
    overflow: hidden;
}

.<?=$nRB?>-i {
    display: inline-block;
    float: left;
    margin-right: 2px;
    height: 3px;
    width: 3px;
    <?=pcss('transition', array(
        "border $tr",
        "background-color $tr",
        //"transform 500ms ".cbn('.87,.28,.04,1.61'),
        "transform 500ms cubic-bezier(.87,.28,.04,1.61)",
    ))?>
}

.<?=$nRB?>-i.-filled {
    border: 1px solid cadetblue;
    background-color: lightcyan;
    <?=pcss('transform', 'scale(1,1)')?>;
}