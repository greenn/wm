$.fn.ppath1 = function() { //parent-path
    var path = '', node = this;
    while (node.length) {
        var realNode = node[0], name = realNode.localName;
        if (!name) break;
        name = name.toLowerCase();

        var parent = node.parent();
        var siblings = parent.children(name);
        if (siblings.length > 1) {
            name += ':eq(' + siblings.index(realNode) + ')';
        }
        var nodeClass = realNode.className;
        if (nodeClass.length) {
            name += '.' + nodeClass.split(/\s+/).join('.');
        }

        path = name + (path ? ' > ' + path : '');
        node = parent;
    }

    return path;
};

$.fn.ppath2 = function() {
    var path = '', node = this;
    while (node.length) {
        var realNode = node[0];
        if (!realNode.localName) break;

        var nodeClass = realNode.className;
        if (nodeClass.length) {
            var name = '.' + nodeClass.trim().split(/\s+/).join('.');
            path = name + (path ? ' > ' + path : '');
        }

        node = node.parent();
    }

    return path;
};

$.fn.ppath3 = function() {
    var path = '', node = this;
    while (node.length) {
        var realNode = node[0];
        if (!realNode.localName) break;

        var nodeClass = realNode.className;
        if (nodeClass.length && /^[A-Z]/.test(nodeClass)) {
            var name = '.';
            name = '';
            name += nodeClass.trim().split(/\s+/).filter(function(cls) {
                return /^[A-Z]/.test(cls);
            }).join('.');
            path = name + (path ? ' > ' + path : '');
        }

        node = node.parent();
    }

    return path;
};


    $.fn.ppath4 = function(specificClasses) {
        var path = '', node = this;
        specificClasses = specificClasses || [];

        while (node.length) {
            var realNode = node[0];
            if (!realNode.localName) break;

            var classes = realNode.className.split(/\s+/).filter(function(cls) {
                return cls && (specificClasses.indexOf(cls) !== -1 || /^[A-Z]/.test(cls));
            });

            if (classes.length) {
                var name = '.' + classes.join('.');
                path = name + (path ? ' > ' + path : '');
            }

            node = node.parent();
        }

        return path;
    };


    $.fn.ppath5 = function(specificClasses) {
        var path = '', node = this;
        specificClasses = specificClasses || [];

        while (node.length) {
            var realNode = node[0], name = '';
            if (!realNode.localName) break;

            // Сначала добавляем специфичные классы
            specificClasses.forEach(function(cls) {
                if (realNode.classList.contains(cls)) {
                    name += '.' + cls;
                }
            });

            // Добавляем остальные классы, начинающиеся с большой буквы
            Array.prototype.forEach.call(realNode.classList, function(cls) {
                if (!specificClasses.includes(cls) && /^[A-Z]/.test(cls)) {
                    name += '.' + cls;
                }
            });

            if (name) {
                path = name + (path ? ' > ' + path : '');
            }

            node = node.parent();
        }

        return path;
    };
