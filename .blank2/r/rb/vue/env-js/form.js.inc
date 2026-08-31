//4.1.1806
<? $js; ?>
const Form = (function(){
    var _log = Log.for('Form');

	<? include $js['form/validator'] //fieldP{ makeItem, }?>

	<? include $js['form/fieldA/align'] //alignFieldData?>

	<? include $js['form/fieldA/item'] //makeFieldItem?>

	<? include $js['form/buttonP'] //buttonP{ makeItem, }?>

    <? include $js['form/fieldP'] //fieldP{ makeItem, }?>




    return {
        validate: validatator.run,

        //01
        pick: function(list, slice){ //pickArray, pickSlice
            return _.reduce(slice, function(pick, ctx, name){
                if (_.isNumber(ctx)) ctx = { size: ctx };
                pick[name] = _.extend(ctx, list[name]);
                return pick;
            })
        },

        <?//field-A ?>
        hasChanges: function(_fields){
            return _.reduce(_fields, function(result, item, name){
                //_log('hasChanges', [name, /*[item.value, item.savedValue],*/ item.value !== item.savedValue]);
                return result + (item.value() !== item.savedValue);
            }, false)
            //_.isEqual(a, b)
        },

        fieldData: makeFieldItem,

        fieldsData: function(dataList, cfg){
            if (!cfg) cfg = {};
            var fieldsList = _.transform(dataList, function(res, data, name){
                var item = makeFieldItem(data, { name: name })

                //_log('fieldsData/item', name, { item: item, data: data });


                res[item.name] = item;
                return res;
            }, {});

            //_log('fieldsData', { data: dataList, result: fieldsList});

            return fieldsList;
        },

        fieldsValue: <? include $js['form/fieldA/values:'] ?>,

	    <?//field-B ?>
        fieldP: fieldP,

        buttonP: buttonP,

    }
})()
