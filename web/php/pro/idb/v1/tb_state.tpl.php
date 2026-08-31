<?

//dx($_ctx);

$_ctx = qtpl::ctx(array(
	'tbName' => '-',
	'isCreated' => null,
	'justCreated' => null,
	'isExist' => null,
), $_ctx);

$tbName = $_ctx['tbName'];
$isCreated = $_ctx['isCreated'];
$justCreated = $_ctx['justCreated'];
?>
<p>
    <button collapse store="tb_<?=$tbName?>">+</button>
    Таблица
    <b><?=$tbName?></b>
    создана
    <?= $isCreated ? '(Да'.($justCreated ? ', только что' : '').')' : '(Нет)'?>
</p>

<section>
    <? d(_sd::info_get_sd($tbName)); ?>
    <? d(_sd::info_get_auto($tbName)); ?>
    <? d(mc::item_all($tbName)); ?>
    <hr />
    <? if ($isCreated) {
        $_id = "rb_$tbName"
    ?>
        <div>
            <label for="<?=$_id?>"><i>Rebuild <u><?=$tbName?></u></i></label>
            <input id="<?=$_id?>" type="checkbox" name="rebuild[<?=$tbName?>]" value="<?=$tbName?>" />
            <button type="submit" name="rebuild[<?=$tbName?>]" value="<?=$tbName?>">Перестроить</button>
        </div>
    <? } ?>
    <? //d(mc::table_all($tbName)); ?>
    <br />
</section>
