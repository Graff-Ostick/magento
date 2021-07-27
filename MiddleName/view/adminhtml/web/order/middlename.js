define([
    'jquery',
    'Magento_Sales/order/create/scripts'
], function ($){
    AdminOrder.prototype.setShippingMethod = function(shipping){
        if (shipping === 'freeshipping_freeshipping') {
            $(".admin__field.field.field-middlename").addClass("required _required");
            $(".admin__field-control.control input.input-text.admin__control-text").addClass("required-entry _required");
        }
        else{
            $(".admin__field.field.field-middlename").removeClass("required _required");
            $(".admin__field-control.control input.input-text.admin__control-text").removeClass("required-entry _required");
        }
    }
})
