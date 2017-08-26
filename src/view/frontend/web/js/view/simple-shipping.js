
define(
    [
        'uiComponent',
        'jquery',
        'Magento_Checkout/js/view/shipping',
        'Magento_Checkout/js/model/quote'
    ], function (
        Component,
        $,
        shipping,
        quote
    ) {
        'use strict';

        quote.shippingMethod.subscribe(function (value) {

            if (value.carrier_code == "simple_shipping") {

                var simpleShipping = window.checkoutConfig.shipping.simpleShipping;
                $(".simple-shipping-content").remove();
                $(".table-checkout-shipping-method").append('<div class="simple-shipping-content"><span>'+simpleShipping.message+'</span></div>');
            } else {
                $(".simple-shipping-content").remove();
            }
        });

        return Component;
    }
);
