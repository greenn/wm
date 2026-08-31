
selectPrice(priceKey){ //00


    var pricesData = this.selectedItem('prices')
    var priceData = pricesData[priceKey];

    _log('selectPrice', { priceKey, hoveredKey: this.hoveredKey });


    return;
    if (this.hoveredKey !== false) {
        //case: underHover
        this.selectedKey = this.hoveredKey;
    }

    var priceData = this.selectedItem('prices')[priceKey];
    _log('selectPrice', { priceData });



    //this.selectedPrice =
    var currentKey = this.hoveredKey !== false ? this.hoveredKey : this.selectedKey;
    var priceId = [currentKey, priceKey];

    if (1) {

    }
    //this.selectedPrice = []price[1]
},