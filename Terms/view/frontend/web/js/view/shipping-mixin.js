define([
    'jquery',
    'Magento_Checkout/js/checkout-data',
    'ko'
], function ($, checkoutData, ko) {
    'use strict';

    let self = null;
    let mixin = {

        initialize: function () {
            self = this;
            this._super();

            let selectedShippingRate = checkoutData.getSelectedShippingRate() || 'flatrate'
            this.toggleRequireField(selectedShippingRate)
        },

        toggleRequireField: function (code) {
            var event = new CustomEvent("updateShippingValidationRules", {
                detail: {
                    cb: function (field) {
                        const isFlatRate = code.indexOf('flatrate') + 1 >= 1
                        field = field['shippingAddress.company']();

                        field.validation['required-entry'] = isFlatRate;
                        if(!isFlatRate) {
                            field.error('')
                        }

                        return field
                    }
                }
            });

            document.dispatchEvent(event);

        },

        selectShippingMethod: function (shippingMethod) {
            self.toggleRequireField(shippingMethod['carrier_code'])
            return this._super(shippingMethod);
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});
