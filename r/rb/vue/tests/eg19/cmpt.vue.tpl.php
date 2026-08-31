<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    //'dirUrl',
    //'strLess'
);

$Self = _rb::self();
$_ctx = $Self::tempCtx(array());

$props = array(
    'propA',
    'propB',
    'propC',
    'propD',
    'propE',
    'propF',
    'propG',
    'author',
    //'author.firstName',
    //'author.firstName',
    'postTitle',
    'status',
);
?>
<? foreach ($props as $prop) { ?>
    <div>
        <span><?=$prop?>:</span>
        <span>{{ <?=$prop?> }}</span>
    </div>
<? } ?>