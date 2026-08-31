<?
//$Root = _rt::name('root');
//dx(rt('root', 'relDir', 'select-1')); //no - неправильно срабатывает авто-определение relDir
//dx(rt('root', 'relDir', 'select-1', __FILE__));
//dx($Root::relDir('select/page'));
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>
<?//=rt('root', 'relDir', 'select-1')?>
<?//=rt('root', 'relDir', 'select-1', __FILE__)?>
<?=rt_tpl('root', rt('root', 'relDir', 'selects-1', __FILE__))?>