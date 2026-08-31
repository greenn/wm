<?

//dx($_ctx);

$_ctx = qtpl::ctx(array(
	'dbName' => '-',
	'justCreated' => null,
	'isConnected' => null,
	'error' => false,
	'proof' => null,
	'proof2' => null,
), $_ctx);

$dbName = $_ctx['dbName'];
$justCreated = $_ctx['justCreated'];
$isConnected = $_ctx['isConnected'];
$error = $_ctx['error'];
$proof = $_ctx['proof'];
$proof2 = $_ctx['proof2'];

?>
<p>
	База
	<?=$dbName?>
	<? if ($justCreated) { ?>
		создана
        <? if ($proof === false) { ?>
            (нет)
        <? } ?>
		<? if ($proof2 === false) { ?>
            (нет)
		<? } ?>
	<? } else { ?>
		в наличии
	<? } ?>
</p>

<p>
	База <?=$dbName?> подключена
	<? if ($isConnected) { ?>
		(Да)
	<? } else { ?>
		(Нет)
	<? } ?>
</p>

<? if ($error) { ?>
    <div>
        <div style="color: red">есть ошибка:</div>
		<?=$error?>
    </div>
<? } ?>