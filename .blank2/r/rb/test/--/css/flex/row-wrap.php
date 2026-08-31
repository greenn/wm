<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/aq');

ob_start();
?>
<style>
    MAIN {
        max-width: 550px;
        outline: 1px dashed orange;
        min-height: 100px;
    }

    SECTION {
        width: 150px;
        height: 200px;
        background-color: cornflowerblue;
        border: 2px solid indianred;
        margin: 10px;
    }

</style>
<main fxr fxw>
    <section></section>
    <section></section>
    <section></section>
</main>

<?
print rb_tpl('page', 'page', array(
   'body' => ob_get_clean()
));