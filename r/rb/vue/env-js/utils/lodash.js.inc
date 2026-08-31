_.prototype.myPush = function(array, value) {
    if (!_.isArray(array)) {
        throw new Error('First argument should be an array');
    }

    array.push(value);
};

_.mixin({
    push: function(obj, value) {
        if (_.isArray(obj)) {
            obj.push(value);
        } else {

            <? if (1) { ?>
                var lastKey = _.last(_.keys(obj))
                obj[+lastKey + 1] = value;
	        <? } ?>
	        <? if (0) { ?>
                //плохо работает если удаляется элемент с индекс 0, то массив превращается в объект,
                //и записываешь на index 2, а 2 уже есть
                var newKey = _.size(obj)
                obj[newKey] = value;
	        <? } ?>
        }
    }
});