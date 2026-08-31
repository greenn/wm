<?
//$_ctx = qtpl::ctx(array(), $_ctx);
?>


<script type="text/javascript" src="<?=qv('/js/jquery/1.12.4/jquery.min.js')?>"></script>
<script>
	var reloadRelFrame = function(){};
	$(function(){
	    var uid_seed = 1;
	    var sid_title = function(id){ return `iframe-load ${id}`; }
	    var sid_title = function(title){ return `${title}: `; }
        reloadRelFrame = function(button_el, omnibox_src){
            var $button = $(button_el);
            var $wrapper = $button.parents('[frame]');

            var $headSection = $('HEADER', $wrapper);
            var $frameSection = $('SECTION[iframe]', $wrapper);
            var $timeOutput = $('SPAN[time]', $headSection);
            var $omnibox = $('INPUT[omnibox]', $wrapper);
            var $frame = $('IFRAME', $frameSection);
            var $cover = $('[cover]', $frameSection);
            var iFrame = $frame[0];
            var sid = $frame.attr('reload_init');

            //var url = omnibox_src ? $omnibox.val() : iFrame.src;
            var url = omnibox_src ? $omnibox.val() : $frame.attr('src');

            var tm;
            var tm_start, tm_end;
            var get_tm_start = function(){ return tm_start; }
            var on_reload_start = function(){
                console.time(sid_title(url));
                //tm = window.performance.now();
                //tm = Date.now();
                //tm_start = window.performance.now();
                //console.log('tm_start|1', tm_start);
                //$timeOutput.text('');

                $button.prop('disabled', true);

                $cover.attr('hide', 'no');
            }

            var on_reload_end = function(){
                console.timeEnd(sid_title(url));
                //tm = window.performance.now() - tm;
                //$timeOutput.text(tm.toFixed(0));
                //tm = (Date.now() - tm) / 1000;
                //$timeOutput.text(tm.toFixed(2));
                //tm_end = window.performance.now();
                //console.log('tm_start|2', tm_start, get_tm_start());
                //tm = tm_end - tm_start;
                //$timeOutput.text(tm.toFixed(0));

                $button.prop('disabled', false);

                $cover.trigger('click');
            }

	        if (!sid) {
                sid = uid_seed++;
	            $frame.attr('reload_init', sid);

                $cover.click(function(){
                    $cover.attr('hide', 'yes');
                });

                $frame.on('load', function(){
                    on_reload_end();
                })
	        }




            on_reload_start();
            //iFrame.contentDocument.location.reload(true);
            if (iFrame.src) {
                iFrame.src = url;
            } else {
                on_reload_end();
            }

        };

	})

    var applyRelFrame = function(){
	    //get value from input
       //reloadRelFrame({ src })
    }

</script>