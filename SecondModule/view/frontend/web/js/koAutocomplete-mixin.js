define(['uiComponent', 'jquery', 'mage/url'], function (Component, $, urlBuilder){
    'use strict';

    var mixin = {

        handleAutocomplete: function (searchValue) {
            if (searchValue.length > 4) {
                $.getJSON(this.searchUrl, {e: searchValue}, function (data) {
                    this.availableSku = $.makeArray( data );

                    var filteredSearch = this.availableSku.filter(function (item) {
                        return item.sku.indexOf(searchValue) !== -1;
                    });
                    this.searchResult(filteredSearch);
                }.bind(this));
            } else {
                this.searchResult([]);
            }}
    };

    return function (target) {
        return target.extend(mixin);
    };
});
