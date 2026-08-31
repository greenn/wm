_vue.provider['__drag-free'] = function(__cfg){
	return {
        data: function(){

            return {
                //lastDragObject: undefined
            }
        },

        methods: {

            easyDrag(event) {
				var $node = $(event.currentTarget);
                window.easyDragLast = event.currentTarget;

				var startX = event.clientX;
				var startY = event.clientY;
                var startTop = parseInt($node.css('top'), 10);
                var startRight = parseInt($node.css('right'), 10);

                var curX = startRight, curY = startTop;
                function onDrag(e) {
                    if (e.buttons) {
                        $node.attr('o1', '');
                        curX = startRight - (e.clientX - startX);
                        curY = startTop + (e.clientY - startY);
                        //_log('onDrag', {'e.buttons': e.buttons, curX, curY, startRight, startTop, startX, startY})
                        $node.css('right', `${curX}px`);
                        $node.css('top', `${curY}px`);
                    } else {
                        stopDrag();
                    }
                }

                function stopDrag() {
                    $node.attr('o1', null);
                    //_log('lastPos', { right: curX, top: curY }, { ppath: $node.ppath5() })
                    _log('lastPos', { right: curX, top: curY })
                    document.removeEventListener('mousemove', onDrag);
                    document.removeEventListener('mouseup', stopDrag);
                }


                document.addEventListener('mousemove', onDrag);
                document.addEventListener('mouseup', stopDrag);

			}
		},

        mounted(){

            var self = this;

            window.addEventListener('keydown', function(event) {
                var element = window.easyDragLast;

                if (!element) return;

                var $node = $(element);
                var curTop = parseInt($node.css('top'), 10);
                var curRight = parseInt($node.css('right'), 10);

                //_log('keydown', { key: event.key, curTop, curRight })

                const step = 1;
                const largeStep = 10;
                const currentStep = event.altKey ? largeStep : step;

                switch (event.key) {
                    case 'ArrowUp': case 'Numpad8': case '8':
                        curTop -= currentStep;
                        break;
                    case 'ArrowDown': case 'Numpad2': case '2':
                        curTop += currentStep;
                        break;
                    case 'ArrowLeft': case 'Numpad4': case '4':
                        curRight += currentStep;
                        break;
                    case 'ArrowRight': case 'Numpad6': case '6':
                        curRight -= currentStep;
                        break;

                    case 'Numpad9': case '9':
                        curTop -= currentStep;
                        curRight -= currentStep;
                        break;
                    case 'Numpad7': case '7':
                        curTop -= currentStep;
                        curRight += currentStep;
                        break;
                    case 'Numpad3': case '3':
                        curTop += currentStep;
                        curRight -= currentStep;
                        break;
                    case 'Numpad1': case '1':
                        curTop += currentStep;
                        curRight += currentStep;
                        break;

                    default:
                        return; // Выход из функции, если нажата другая клавиша
                }

                _log('lastPos', { right: curRight, top: curTop })//, { ppath: $node.ppath5() })

                $node.css('right', `${curRight}px`);
                $node.css('top', `${curTop}px`);
            });


        }
	}


}
