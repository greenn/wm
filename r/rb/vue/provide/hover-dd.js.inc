

_vue.provider['__hover-dd'] = function(__cfg){
    return {
        methods: {

            hoverEf1(event){
                var node = event.target;
                var $node = $(node);
                var w = window.innerWidth / 2;
                w = $node.innerWidth(); //node.clientWidth
                //w = $node.outerWidth(); //node.offsetWidth

                let xAxis = (w / 2 - event.clientX) / 25;
                let yAxis = (w / 2 - event.clientY) / 25;

                xAxis = (event.clientX - window.innerWidth / 2) / 20;
                yAxis = (event.clientY - window.innerHeight / 2) / 20;


                if(1) _.once(function(){
                    _log('hoverEf1::INFO', { transform: $node.css("transform") })
                })

                _log('hoverEf1', $node.ppath5())
                $node.css("transform", `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`);


            },


            hoverEf2Reset(event){},

            //@mousemove="hoverEf1"
            // @mousemove="hoverEf2"
            hoverEf2(event){
                var containerNode = event.target;
                var $container = $(containerNode);

                var nodeSr = $container.attr('hover-obj');
                var $node = nodeSr ? $(nodeSr, $container) : $container

                const multiple = 10;
                let box = $node[0].getBoundingClientRect();
                var x = event.clientX;
                var y = event.clientY;
                const calcX = -(y - box.y - box.height / 2) / multiple;
                const calcY = (x - box.x - box.width / 2) / multiple;
                const percentage = parseInt((x - box.x) / box.width * 1000) / 10;

                $node.css("transform", "rotateX(" + calcX + "deg) " + "rotateY(" + calcY + "deg)");


                $container.on('mouseleave', function(){
                    $node.css("transform", 'rotateX(0) rotateY(0)');
                })

            },

        }
    }
}