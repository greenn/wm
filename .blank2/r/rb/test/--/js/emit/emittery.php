<?/*
    https://github.com/sindresorhus/emittery
*/?>
<script src="/js/emittery/0.6.0/index.js"></script>
<script>
    //const Emittery = require('emittery');
    export default;

    const emitter1 = new Emittery({debug: {name: 'emitter1', enabled: true}});
    const emitter2 = new Emittery({debug: {name: 'emitter2'}});

    emitter1.on('test', data => {
        // …
    });

    emitter2.on('test', data => {
        // …
    });

    emitter1.emit('test');
    //=> [16:43:20.417][emittery:subscribe][emitter1] Event Name: test
    //	data: undefined

    emitter2.emit('test');
</script>
