<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
    'rName' => '',
    'tplName' => '',
    'vueName' => '',
));
$rName = $_ctx['rName'];
$tplName = $_ctx['tplName'];
$vueName = $_ctx['vueName'];

//_kot::req_vue('ui', 'lay/lay-section', array(), 'lay-section'); //mbd kot('ui', 'req_vue_name', 'lay-section');
//_kot::req_vue('side-menu', 'side-menu');
_kot::req_vue($rName, $tplName, array(), $vueName);
//d($rName, $tplName, $vueName);

print "<$vueName></$vueName>";
