var nameIndexMap = { width: 0, height: 1, thick: 2 };
var matchForSizes = function(sizeName, sizeValue){
    var selectedData = selectedSize;
    selectedData[sizeName] = sizeValue;

    //step: проверяем размеры, на свопадение с selectedData
    var matches = [];
    _.each(sizes, function(data, sizeIdn){
        var size = data.sizes;

        var matchSize = false;
        _.each(selectedData, function(selectedValue, selectedName){
            var sizeNameIndex = nameIndexMap[selectedName];
            matchSize *= size[sizeNameIndex] === selectedValue
        })
        if (matchSize) {
            matches.push(sizeIdn)
        }
    })

    return matches.length;
}