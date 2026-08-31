<?
$Self = _site::self();
$n = $Self::nc();

$Self::req_css('footer');

//$_ctx = $Self::tempCtx(array());

?>
<?//=site_tpl('css', 'editor');?>
<div class="<?=$n?> site-p">
    <div indent="<?=$n?>-top"></div>
    <div class="site-w" <?//=_aos('fade-up')?>>
        <div fxr class="<?=$n?>-c">
            F-o-o-t-e-r
        </div>
    </div>
    <div indent="<?=$n?>-bottom"></div>
</div>