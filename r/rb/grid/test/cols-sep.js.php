<?
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';

$Self = self_rp();
$nG = $Self::nc();

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(
		$nG
	),
	__FILE__
), SITE_CACHE);

//wjs::req('llog');
?>


$(function(){

    var $cols = $('.<?=$nG?>-cell');
    $cols.each(function(){
        var cn = this.getAttribute('class').replace('<?=$nG?>-cell', '');
        $('<div />', { class: 'cn', text: cn }).prependTo(this);
        $('<div />', { class: 'size-info', css: { 'text-align': 'center' } }).appendTo(this);
        $('<div />', { class: 'size-info-par', css: { 'text-align': 'center' } }).appendTo(this);
    });

    var syncSizeInfo = function(){
        $cols.each(function(){
            var $cell = $(this);
            var $cellB = $('.<?=$nG?>-cell-b', this);
            var $cellW = $('.<?=$nG?>-cell-w', this);
            var $sizeInfoPar = $('.size-info-par', $cell);
            var $sizeInfo = $('.size-info', $cell);
            var w = $cellW.width();
            var wPar = $cell.width();
            var ml = parseInt($cellB.css('margin-left'));
            var mr = parseInt($cellB.css('margin-right'));
            var pl = parseInt($cellB.css('padding-left'));
            var pr = parseInt($cellB.css('padding-right'));
            $sizeInfo.html([
                '<span title="' + ml + '|' + pl + '">(' + (ml + pl) + ')</span>',
                w,
                '<span title="' + mr + '|' + pr + '">(' + (mr + pr) + ')</span>',
            ].join(' '));

            $sizeInfoPar.html(wPar)
        })
    }


    $(window).resize(syncSizeInfo)
    syncSizeInfo();
})