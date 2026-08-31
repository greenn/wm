<?/*
    https://github.com/sindresorhus/emittery
*/?>
<script src="/js/emittery/0.6.0/index.standalone.js"></script>
<script>
    console.log(Emittery);
    var emittery = new Emittery();

    var R1 = emittery.on('e1', function(a){
        console.log('e1', 1, a);
    });
    var R2 = emittery.on('e1', function(a, b){
        console.log('e1', 2, a, b);
    })

    var R3 = emittery.emit('e1', 'A', 'B');
    //emittery.emit('e1', ['A', 'B'], 22);

    //import Emittery from 'emittery';
    //import * as myModule from '/js/emittery/0.6.0/index.js';
    //import myDefault from '/js/emittery/0.6.0/index.js';
    console.log({ R1, R2, R3 })
</script>
