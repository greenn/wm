var { range, filter, map } = rxjs;
console.log('rxjs', { range, filter, map });

range(1, 200)
    .pipe(
        filter(x => x % 2 === 1),
        map(x => x + x)
    )
    .subscribe(x => console.log(x));
