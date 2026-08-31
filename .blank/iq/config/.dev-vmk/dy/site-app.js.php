bindOnReady({
    nodes(){
        return $('[rclick]');
    },
    bind($nodes){
        //console.log('rclick/init', { '$nodes.length': $nodes.length });
        $nodes
            .on('mousedown', function() {
                $(this).addClass('-click');
            })
            .on('mouseup', function() {
                $(this).removeClass('-click');
            })
        ;
    }
});


//-   -   -   - -   -   -   -   -


bindOnReady({
    nodes(){
        return $('[rhover]');
    },
    bind($nodes){
        console.log('rhover/init', { '$nodes.length': $nodes.length });

        $nodes.hover(function() {
            $(this).toggleClass('-hover');
        });
        /*
            $nodes.hover(
                function(){
                    $(this).addClass('-hover');
                },
                function(){
                    $(this).removeClass('-hover');
                },
            );
        */
    }
})

