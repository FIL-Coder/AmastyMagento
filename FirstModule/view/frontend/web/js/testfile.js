define(['jquery'], function ($) {
    $.widget('custom.firstwidget', {
        options: {
            selector: null
        },
        _create: function () {
            this.hideElement();
        },
        hideElement: function () {
            $(this.options.selector).hide();
            $(this.element).hide();
        }
    });

    return $.custom.firstwidget;
});
