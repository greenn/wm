<?/*
    <script src="https://unpkg.com/mitt/dist/mitt.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mitt@3.0.0/dist/mitt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tiny-emitter/dist/mitt.min.js"></script>
*/?>
<script src="/js/tiny-emitter/2.1.0/index.js"></script>
<script>
    //var Emitter = require('tiny-emitter');
    var emitter = new Emitter();

    emitter.on('some-event', function (arg1, arg2, arg3) {
        //
    });

    emitter.emit('some-event', 'arg1 value', 'arg2 value', 'arg3 value');
</script>
