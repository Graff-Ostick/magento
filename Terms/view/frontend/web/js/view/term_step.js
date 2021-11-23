define(
    [
        'ko',
        'uiComponent',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Customer/js/model/customer',
        'Magento_Customer/js/customer-data',
        'jquery'
    ],
    function (
        ko,
        Component,
        _,
        stepNavigator,
        customer,
        customerData,
        $
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Test_Terms/terms'
            },
            isVisible: ko.observable(true),
            isLoggedIn: customer.isLoggedIn(),
            stepCode: 'terms',
            stepTitle: 'Additional Terms and Conditions',

            /**
             *
             * @returns {*}
             */
            initialize: function () {
                this._super();
                stepNavigator.registerStep(
                    this.stepCode,
                    null,
                    this.stepTitle,
                    this.isVisible,
                    _.bind(this.navigate, this),
                    5
                );

                return this;
            },

            show_checkbox: function (){
                let count_items = customerData.get('cart')().items.length;
                let qty = customerData.get('cart')().items[0].qty;
                let res = false;

                if (qty > 1 || count_items > 1){
                    res = true;
                    $("#terms-checkbox").prop( "checked", false );;
                }
                return res;
            },

            navigate: function () {

            },

            /**
             * @returns void
             */
            navigateToNextStep: function () {
                if ($("#terms-checkbox").prop( "checked" )) {
                    stepNavigator.next();
                }
                else{
                    $("#terms-text").css("color", "red");
                }
            }
        });
    }
);
