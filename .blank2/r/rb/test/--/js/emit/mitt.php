<?/*
    <script src="https://unpkg.com/mitt/dist/mitt.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mitt@3.0.0/dist/mitt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tiny-emitter/dist/mitt.min.js"></script>
*/?>
<script src="/js/mitt/3.0.0/mitt.js"></script>
<script>
    const emitter = mitt()

    // listen to an event
    //emitter.on('foo', e => console.log('foo', e) )
    emitter.on('foo', function (e) {
        return console.log('foo', e);
    });

    // listen to all events
    //emitter.on('*', (type, e) => console.log(type, e) )
    emitter.on('*', function (type, e) {
        return console.log(type, e);
    });

    // fire an event
    emitter.emit('foo', { a: 'b' })

    // clearing all events
    emitter.all.clear()

    // working with handler references:
    function onFoo() {}
    emitter.on('foo', onFoo)   // listen
    emitter.off('foo', onFoo)  // unlisten
</script>
