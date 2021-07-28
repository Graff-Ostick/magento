
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'custompayment',
                component: 'Test_CheckoutPayMethod/js/view/payment/method-render/custompayment'
            }
        );
        return Component.extend({});
    }
);
