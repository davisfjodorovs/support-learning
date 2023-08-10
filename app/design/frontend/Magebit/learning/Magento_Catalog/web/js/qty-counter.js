define(
    ['uiComponent', 'ko']
    ,function (Component, ko) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Magento_Catalog/input-counter'
            },

            initialize: function (config) {
                this._super();
                this.qty = ko.observable(config.defaultValue);
                // this.titleAttribute = ko.observable(config.title);
                // this.validateAttribute = ko.observable(config.validate);
            },

            increaseQty: function () {
                this.qty(this.qty() + 1);
            },

            decreaseQty: function () {
                if(this.qty() > 0) {
                    this.qty(this.qty() - 1);
                }
            },
        });
    });
