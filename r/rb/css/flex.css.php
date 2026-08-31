<?#1.7.1
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
/*
-   -   -   -   eg
fxr -  в строку
fxс - в колонку

fxr="sb" fxi="c"
	fxr fxi="c"
fxi="c"
fxr="fe" fxi="fs"
<ul fxr fxi="c" rst="li">

-   -   -   -   man
fxi align-items
	c center
	fs flex-start
	fe flex-end

	s stretch

	b baseline

fxr|fxc align-content / justify-content
	c center
	fs flex-start
	fe flex-end

	sb space-between
	sa space-around

	se stretch / space-evenly

*/
?>

<? foreach (array(
    '.fx', '.fxc', '.fxr', '.fxi', '.fxw', '.fxn',
    '[fx]', '[fxc]', '[fxr]', '[fxi]', '[fxw]', '[fxn]',
    '[fx2]', '[fxi2]', '[fxc2]', '[fxr2]', '[fx2]',
) as $sr) { ?>
    <?=$sr?> {
        <?=pcss('display', 'flex')?>
    }
<? } ?>


[ifxc], [ifxr] {
    <?=pcss('display', 'inline-flex')?>
}

.fxr,
[fxr2],
[fxr] {
    <?=pcss('flex-direction', 'row')?>
}

.fxc,
[fxc2],
[fxc] {
	<?=pcss('flex-direction', 'column')?>
}


.fxw,
[fxw] {
    <?=pcss('flex-wrap', 'wrap')?>
}

.fxn, .fxw-no,
[fxn], [fxw="no"] {
    <?=pcss('flex-wrap', 'nowrap')?>
}

.fg,
[fg] {
    <?=pcss('flex-grow', 1)?>
}
<? foreach (range(0,5) as $N){ ?>
.fg<?=$N?>,
[fg<?=$N?>],
[fg="<?=$N?>"] {
    <?=pcss('flex-grow', $N)?>
}
<? } ?>


<? foreach (array(
    'fxc' => 'align-content', 'fxc2' => 'align-content',
    'fxci' => 'justify-content', 'fxci2' => 'justify-content',
    'fxr' => 'justify-content', 'fxr2' => 'justify-content',
) as $np => $prop) { ?>
    <? foreach (array(
        'c' => 'center',
        'fs' => 'flex-start',
        'fe' => 'flex-end',
        'sb' => 'space-between',
        'sa' => 'space-around',
        'se' => array('stretch', 'space-evenly'),
    ) as $nv => $value) {
        $index = startsWith($np, 'fxc') ? 0 : 1;
        if (is_array($value)) $value = $value[$index];
    ?>
    .<?=$np?>-<?=$nv?>,
    [<?=$np?>="<?=$nv?>"] {
        <?=pcss($prop, $value)?>
    }
    <? } ?>
<? } /* eg
[fxr="fs"] {
    <?=pcss('alingn-content', 'flex-start')?>
}

*/?>

<? $prop = 'align-items'; ?>
<? foreach (array('fxi', 'fxi2') as $np) { ?>
    <? foreach (array(
        'c' => 'center',
        'fs' => 'flex-start',
        'fe' => 'flex-end',
        's' => 'stretch',
        'b' => 'baseline',
    ) as $nv => $value) { ?>
        .<?=$np?>-<?=$nv?>,
        [<?=$np?>="<?=$nv?>"] {
            <?=pcss($prop, $value)?>
        }
    <? } ?>
<? } ?>


.fx-va,
[fxva],
[fx="va"] {
	<?=pcss(array(
       'display' => 'flex',
	   'flex-direction' => 'column',
	   'justify-content' => 'center',
	))?>
}

[fxcc] {
    <?=pcss(array(
       'display' => 'flex',
       //'flex-direction' => 'column',
       'justify-content' => 'center',
       'align-items' => 'center',
    ))?>
}

<?/*            lay
    lc - lay column
                                        */?>
[lc="3"] {
    width: 33.3%;
}
[lc="2"] {
    width: 50%;
}