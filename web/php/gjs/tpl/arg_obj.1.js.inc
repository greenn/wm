if (!set || typeof(set) !== 'object') {
    if (typeof(set) == 'function') set = set();
    set = { n: typeof(set) == 'string' ? set : false };
}