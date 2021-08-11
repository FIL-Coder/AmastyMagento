define(['uiComponent', 'jquery', 'mage/url'], function (Component, $, urlBuilder) {
    return Component.extend({
        defaults: {
            searchText: '',
            searchUrl: urlBuilder.build('firstmodule/search/product'),
            searchResult: [],
            availableSku: []
        },
        initObservable: function () {
            this._super();
            this.observe(['searchText', 'searchResult']); // searchResult будет хранить значение результатов поиска
            return this;
        },
        initialize: function () {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this));
        },
        handleAutocomplete: function (searchValue) {
            if (searchValue.length > 2) {
                $.getJSON(this.searchUrl, {e: searchValue}, function (data) {
                    this.availableSku = $.makeArray( data );

                    var filteredSearch = this.availableSku.filter(function (item) {
                        return item.sku.indexOf(searchValue) !== -1;
                    }); // получаем массив из значений availableSku в которых есть строка, введенная в input
                    this.searchResult(filteredSearch); // записываем этот массив в переменную searchResult
                }.bind(this));
            } else {
                this.searchResult([]);
            }}
    });
});
