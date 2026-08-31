<?
$Self = _site::self();
//$n = $Self::nc();
$nPR = $Self::nc('PR');

//$Self::req_css('blank');
//$Self::req_js('blank');

$_ctx = $Self::tempCtx(array('var' => ''));
$var = $_ctx['var'];

?>

<div class="<?=$nPR?>">
    <div>

        Поиск для: <?=gt('q')?>;
    </div>
    <div>
        Найдено: …
    </div>
    <div>
        В контактах: …
    </div>

    <div>
        В каталоге: …
    </div>

    <div>
        В услугах: …
    </div>

    <div>
        В статьях: …
    </div>



    <div r h500>
	<?=site_tpl('ui', 'preloader', array(
        'fixed' => false
    ))?>
    </div>
</div>