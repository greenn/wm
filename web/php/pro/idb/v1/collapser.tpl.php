<?
//dx($_ctx);
$_ctx = qtpl::ctx(array(
	//'dbName' => '-',
), $_ctx);
?>
<script type="text/javascript">
	$(function(){
	    var Collapser = function($btn, index){
	        var defValue = true;
            var state = true; //collapse? true
            if ($btn.text() === '-') state = false;
            else if ($btn.text() === '+') state = true;

            var store = false;
            var storeName = $btn.attr('store');
            if (storeName) store = {
                nm: 'collapser',
                get: function(){
                    var value = App.store.get(['collapser', storeName]);
                    //console.log('collapser/store/get', { value });
                    return typeof value === 'undefined' ? defValue : value;
                },
                save: function(){
                    var res = App.store.set(['collapser', storeName], state);
                    //console.log('collapser/store/save', { state, res });
                },
            }

            if (store) state = store.get()

            var sr = $btn.attr('collapse');
            var $sr = !sr ? $btn.parent().next('SECTION') : $(sr);

            //console.log('collapser', { sr, $sr: $sr , $sr_length: $sr.length}, );
            //console.log('collapser/syncState', { index, state } );

            var toggleState = function(){
                state = !state;
                store && store.save();
            }
            var syncState = function(){
                if (state) {
                    $btn.text('+')
                    $sr.hide();
                } else {
                    $btn.text('-')
                    $sr.show();
                }
            }

            syncState();
            return {
                trigger: function(){
                    toggleState();
                    syncState();
                }
            }
	    }

	    $('[collapse]').each(function(index){
	        var $btn = $(this);
            var collapser = Collapser($btn, index);

            $btn.click(function(){
                collapser.trigger();
                return false;
            })

	    })
	})
</script>
