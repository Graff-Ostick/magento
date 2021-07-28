define(
    [
        'mage/translate',
        'Magento_Checkout/js/model/quote',
        'Magento_Ui/js/model/messageList'
    ],
    function ($t, quote, messageList) {
        'use strict';
        return {
            validate: function () {
                var emailValidationResult = false;
                var email = quote.guestEmail;
                console.log('validator function work');
                if(~email.search("gmail.com")){
                    emailValidationResult = true;
                }
                else{
                    emailValidationResult = false;
                    messageList.addErrorMessage({ message: $t('email must end "@gmail.com"  ') });
                }
                return emailValidationResult;
            }
        }
    }
);
