<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/aq');

ob_start();
?>
<style>
    .box-w {
        padding: 50px;
        width: 300px;

    }
    [dbg="line"] {
        left: 40px;
        top: 50px;
        height: 100px;
        width: 1px;
        background-color: lightcoral;
    }
    .cube {
        height: 100px;
    }

</style>
<div r class="box-w">
    <div a dbg="line"></div>
    <div fxc fxw o1 class="cube">
        <div class="front"> Front </div>
        <div class="back"> Back </div>
        <div class="top"> Top </div>
        <div class="bottom"> Bottom </div>
        <div class="left"> Left </div>
        <div class="right"> Right </div>
    </div>

</div>

<?
print rb_tpl('page', 'page', array(
   'body' => ob_get_clean()
));