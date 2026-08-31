


prodData1(){
    var self = this;
    var listData = this.list;
    return function(idn, prop) {
        var itemData = self.getProd(idn);
        return prop ? itemData[prop] : itemData;
    }
},



getProdPrice(idn){


    this._log('getProdPrice', { prodData })

    var savedprice = this.getProdInfo(idn, '<?=$nlPrice?>')

}
