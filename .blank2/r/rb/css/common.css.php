<?
/*
    oo
        site/css/inc/common.css.inc
        site/css/inc/lays.css.inc
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
//$Self = _rb::self();

$tr = css('tr0');
$trq = css('trq1');
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
), SITE_CACHE);
?>



.-hide {
    display: none;
}
.-show {
    display: inherit;
    display: block;
}

.-hidden {
    visibility: hidden;
}
.-visible {
    visibility: visible;
}

.indent {
    <?=pcss('transition', array(
        "height $tr",
        "margin-top $tr",
        "margin-bottom $tr",
    ))?>
}

.wq {
    <?=pcss('transition', array(
        "width $tr",
        "margin $tr",
        "padding-left $tr",
        "padding-right $tr",
    ))?>
}

[tqs], [tq], [tq] *,<?//tq0 tq1 tqs(self) tqt(this) tqc(cur)?>
.tq, .tq_, .tq_ *,
.tmq, .tmq_, .tmq_ * {
    <?=pcss('transition', array(
            "font-weight $trq",
        "font-size $trq",
        "line-height $trq",
        "letter-spacing $trq",
        "color $tr",
    ))?>
}

IMG.imq {
    <?=pcss('transition', array(
        "width $trq",
        //"filter $tr",
    ))?>
}

.hidden-submit { <?// https://jsfiddle.net/u9ew1xht/9/ +new_upd?>
    display: block;
    height: 0;
    width: 0;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.irep {
    display: inline-block;
    background-repeat: no-repeat;
    background-position: left top;
    <?=pcss('background-size', 'contain')?>
    -outline: 1px dotted aqua;
}
.irep IMG {
    display: none;
    width: 100%;
    height: 100%;
}


.avh {
    position: absolute;
    height: 100%;
    width: auto;
    left: 50%;
    top: 50%;
    <?=pcss('transform', 'translate(-50%, -50%)')?>;
}


/* lays */
<?// lays / чипсы ?>

<?//qu -'flex' ?>
.flex-row {
<?=pcss(array(
	'display' => 'flex',
	'flex-grow' => '1',

	//'order' => '0',
	/*
	'flex' => '0 1 auto',
		'flex-grow' => '0',
		'flex-shrink' => '1',
		'flex-basis' => 'auto',
	*/
	'flex-direction' => 'row',
	//'flex-shrink' => '1',
	//'align-self' => 'auto',
))?>
    -outline: 1px solid aqua;
}

.flex-cell {
    <?=pcss(array(
        'display' => 'flex',
        'flex-grow' => '1',

        //'flex-shrink' => '1',
    ))?>
}

.flex-column {
    <?=pcss(array(
        'display' => 'flex',
        'flex-direction' => 'column',
        //'flex-wrap' => 'nowrap',
        //'justify-content' => 'flex-start',
        //'align-items' => 'stretch',
        //'align-content' => 'stretch',
        //'align-items' => 'flex-start',
    ))?>
}


.flex-va {
    <?=pcss(array(
       'display' => 'flex',
       'flex-direction' => 'column',
       'justify-content' => 'center',
    ))?>
}


.flex-hr {
    <?=pcss(array(
       'display' => 'flex',
       'flex-direction' => 'column',
       'align-items' => 'flex-end',
    ))?>
}
<?// float fix ?>


*[break]:after {
    content: "\a";
    white-space: pre;
}