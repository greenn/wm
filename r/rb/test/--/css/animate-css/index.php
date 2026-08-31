<script src="/js/jquery/1.12.4/jquery.min.js"></script>
<script src="/js/w/click-class.jq.js.php"></script>
<link type="text/css" rel="stylesheet" href="/css/animate/411/animate.css" />
<link type="text/css" rel="stylesheet" href="/rb/page/css/base.css.php" />
<link type="text/css" rel="stylesheet" href="/rb/lay/flex.css.php" />


<style type="text/css">
    SECTION {
        background-color: lightgoldenrodyellow;
        padding: 15px;
    }
    SECTION > DIV, BUTTON {
        margin-right: 2px;
    }
    LABEL:after {
        content: ':';
    }
    BUTTON.-pressed {
        border-style: dashed;
    }
    BUTTON.-hover {
        background-color: lightgreen;
    }

    MAIN {
        background-color: white;
    }

    #object {
        padding: 20px;
        border: 4px dashed lightblue;
        transform: scale(2);
    }
</style>

<div fxc style="height: 100%;">
    <section fxr fxn>
        <div hover>
            hover:
            <button>flip</button>
        </div>
        <div click>
            click:
            <button>flip</button>
        </div>
        <div set>
            <button>animate__animated animate__bounce</button>
            <button>animate__animated animate__bounce animate__delay-2s</button>
            <button>animate__animated animate__bounce animate__faster</button>
            <button>animate__animated animate__bounce animate__repeat-2</button>
            <button>animate__animated animate__fadeInLeft</button>

        </div>
        <div temp>
            <button>flip</button>
        </div>
        <div click>
            <button onclick="sync_object_className()">nc</button>
        </div>
    </section>
    <section info>
        <div>object info:</div>
        <div cn>
            <label>class</label>
            <var></var>
        </div>
        <div isA>
            <label>isAnimating</label>
            <var></var>
        </div>
        <div event>
            <label>animationcancel</label>
            <var></var>
        </div>
        <div event>
            <label>animationend</label>
            <var></var>
        </div>
        <div event>
            <label>animationiteration</label>
            <var></var>
        </div>
        <div event>
            <label>animationstart</label>
            <var></var>
        </div>

    </section>
    <main fg1 class="flex-va">

        <div tc id="object" class="">
            <div icon>☺</div>
            <div>text</div>
        </div>
    </main>
</div>

<script>

    $(function(){
        var $object = $('#object');
        var isAnimating = false;

        var $isASection = $('SECTION[info] DIV[isA] VAR');
        $object.on('animationstart', function(){ isAnimating = true; $isASection.text('yes') })
        $object.on('animationend animationcancel', function(){ isAnimating = false; $isASection.text('no') })

        var $ncSection = $('SECTION[info] DIV[cn] VAR');
        sync_object_className = function(){
            var nc = $object.attr('class');
            $ncSection.text(nc);
        }

        //var init_object_info = function($node){}
        $('SECTION[info] DIV[event]').each(function(){
            var event = $('LABEL', this).text();
            var $output = $('VAR', this);
            $object.on(event, function(){
                $output.append(document.createTextNode('+'));
            })
        })
        var ncPressed = '-pressed';
        var init_set_button = function($button){
            var nc = $button.text();
            var hasClass = $object.hasClass(nc);
            var reverseState = function(){
                hasClass = !hasClass;
            }
            var syncButtonState = function(){
                $button[hasClass ? 'addClass': 'removeClass'](ncPressed);

            }
            var applyState = function(){
                $object[hasClass ? 'addClass': 'removeClass'](nc);
                syncButtonState();
                sync_object_className();
            };
            var actClick = function(){
                reverseState();
                applyState();
            }

            $button.click(function(){
                actClick();
            });
            syncButtonState();
        }

        var init_temp_button = function($button){

            if(0) $button.clickClass({
                'nc': 'shake-404',
                'tm': 250,
                'stopPropagation': true
            });

        }

        $('SECTION DIV[set] BUTTON').each(function() {
            init_set_button($(this));
        });

        $('SECTION DIV[temp] BUTTON').click(function(){
            init_temp_button($(this));
        })


        //видимо работает только для jquery анимаций
        /*var isObjectAnimating = function(){
            console.log('isObjectAnimating', [$object.is(':animated')]);
            return $object.is(':animated')
        };*/

        var ncHover = '-hover';
        var init_button = function(type, $button){
            var nc = ['animate__' + $button.text()];
            nc.push('animate__animated');
            nc.push('animate__infinite');
            //nc.push('animate__slow');
            nc.push('animate__delay-4');
            nc = nc.join(' ');
            var set = function(){ $object.addClass(nc); sync_object_className() }
            var unset = function(){ $object.removeClass(nc); sync_object_className() }


            var init = {}
            init.hover = function(){
                //console.log('hover', [nc, $button]);
                $button
                    .mouseenter(function(){
                        $button.addClass(ncHover)
                        set()
                    })
                    .mouseleave(function(){
                        $button.removeClass(ncHover)
                        unset()
                    })
                ;
            }

            init.click = function(){
                $button.click(function(){
                    if (isAnimating) {
                        unset()
                    } else {
                        set();
                        $object.on('animationend', function(){
                            unset()
                        })
                    }

                })
            }

            init[type]();
        }



        $('SECTION DIV[hover] BUTTON').each(function(){
            init_button('hover', $(this))
        })

        $('SECTION DIV[click] BUTTON').each(function(){
            init_button('click', $(this))
        })

    })
</script>