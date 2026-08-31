<?

$Self = _rw::name('tool-css');

css::req('rw', 'tool-css', 'app.css.php');
//css::rw_req('tool-css', 'app.css.php');

js::req('rw', 'tool-css', 'app.js.php');

//vue::req('rw', 'tool-css', 'calc-vu');
vue::req('rw', 'tool-css', 'calc-vu/calc-vu', false, 'calc-vu');
css::req('rw', 'tool-css', 'calc-vu/calc-vu.css.php');
//vue::rw_req('tool-css', 'calc-vu');

//dx($Self::_cfg());
$_ctx = $Self::tempCtx(array(

));

?>
<div id="app">

    <h1>Css tools</h1>
    <calc-vu></calc-vu>
    <!--<calc-vu></calc-vu>-->
</div>