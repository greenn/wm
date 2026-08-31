<?#0.4

//это template для функции uv_gen_page()

/* [pr]
    проблема в том, что один и тот же url-может иметь разное содержание,
        в зависмости от некоторых установок: платформы или пользователя
        но при генерации вресии - срабатывает только один вариант, зависящая от места генерации
            плохо
        при etag - оно генерит разные etag
        по-хорошему в момент указания генерации версии - указываетб и хранить в кофиге, что данные url,
            надо генерить в разные вариантых
*/
/*[ td
    даты обновления
        сортировка по датам

    проверка если содержимое файла нет - выделять красным
        [eh или с ошибками preg-match на php-warning | fatal error] - выделять синим

]*/

_needphp('isMobile');
/*

$mode_mobile = isset($_GET['m']);
$mode_me = isset($_GET['i']);
//$mode_dbg = isset($_GET['i']); //isDbg', isset($_COOKIE['dbg']
//$mode_lang
$has_mode = $mode_mobile || $mode_me;

mobileMode($mode_mobile);
*/

$prev_list = urlVersion::$db;

notch_start('vq-web-js');
$new_list = urlVersion::db_rebuild();
$time = notch_end('vq-web-js');

//dx($prev_list, $new_list);
krsort($new_list);

$verShow = array(UV_CONTENT, UV_ETAG, UV_HEADERS);
$verNames = array(UV_CONTENT => 'content', UV_ETAG => 'etag', UV_HEADERS => 'headers');
?>

<style type="text/css">
    DIV[h] B { font: 25px/30px monospace; color: green; }
    DIV[h] B[m] { color: green; }
    DIV[h] B[i] { color: red; }
    TH { font-weight: bold; }
    TH, TD { font-family: monospace; padding: 1px 5px; }
    TD[url] { padding-right: 10px; }
    TD[ver] { padding: 0 3px; }
    TD[upd] { font-weight: bold; }
    TD[upd][ver="0"] { color: green; }
    TD[upd][ver="1"] { color: blue; }
    TD[upd][ver="2"] { color-: darkred; }
    TD[upd][ver="3"] { color-: darkorange; }
</style>
<h5><?=$time?></h5>
<div a>
    <? _needphp('fileUrl'); print fileUrl(urlVersion::$db_path); ?>
</div>

<div h>
    <? if (isMobile){ ?><b m>m</b><? } ?>
    <? if (isMe): ?><b i>i</b><? endif ?>
</div>
<table>
    <tr>
        <th>f5 <button title="всё" onClick="window.location.reload()">🗘</button></th>
        <th>version url \ abc <button disabled>↓</button> <button disabled>↑</button></th>
        <?foreach ($verShow as $index => $ver) { ?>
            <th><?=$verNames[$ver]?></th>
        <?}?>
        <th>date <button disabled>↓</button> <button disabled>↑</button></th>
        <th>X <button disabled title="все">x</button></th>
        <th>t <button disabled>↓</button> <button disabled>↑</button></th>
    </tr>
    <?foreach ($new_list as $url => $new_conf) { //d($new_conf); ?>
        <tr>
            <td><button disabled>🗘</button></td>
            <td url><?=$url?></td>
            <?foreach ($new_conf['ver'] as $index => $ver) if (in_array($index, $verShow)){ ?>
                <? $upd = @$prev_list[$url]['ver'][$index] !== $ver; ?>
                <? $title = str_replace("\r\n", '&#013;', htmlentities($new_conf['verdata'][$index])); ?>
                <td ver="<?=$index?>" <?=$upd ? 'upd' : ''?> title="<?=$title?>"><?=$ver?></td>
            <?}?>
            <td></td>
            <td><button disabled>x</button></td>
            <td><?=@$new_conf['calcTime']?></td>
        </tr>
    <?}?>
</table>




<?
    /*if ($mode_mobile) {
        mobileMode('auto');
    }
    if ($mode_me) {
        setcookie('isMe', '', 1, '/', $HOST); //[oo web/url/info/me.php]
    }*/
?>