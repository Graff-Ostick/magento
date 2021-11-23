define([
    'uiComponent',
    'ko',
    'Magento_Ui/js/modal/modal',
    'jquery',
    'mage/validation',
    'Magento_Ui/js/modal/alert'

], function (Component, ko, modal, $, validation, alert) {
    return Component.extend({

        initialize: function (config) {
            this.url = config.url;
            this.sku = config.sku;
            this.created = config.created;

            this.addValidationForm();
            this.initModal();
            this._super();

        },

        onSubmit: function (e) {
            e.preventDefault();
            this.addValidationForm();
            let name = $("#rp-name").val();
            let email = $("#rp-email").val();
            let comment = $("#rp-comment").val();

            if ($("#custom-form").valid()) {
                this.createRequest({name, email, comment});
            }
        },

        createRequest: function (params) {
            $.ajax({
                url: this.url,
                type: "POST",
                data: {
                    name: params.name,
                    email: params.email,
                    comment: params.comment,
                    sku: this.sku,
                    created_at: this.created,
                    status: 'New'
                },
                showLoader: true,
                success: function (res){
                    alert({
                        content: res.message
                    });
                    this.closeModal();
                }.bind(this)
            });
        },

        addValidationForm: function (){
            let dataForm = $('#custom-form');
            let ignore = null;
            dataForm.validation();

        },

        initModal: function () {
            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Request the price',
                buttons: [{
                    text: 'Close',
                    class: 'modal-close',
                    click: this.closeModal,
                }
                ]
            };

            modal(options, $('#modal-content'));
            $("#price-request-btn").on('click', this.openModal);

            $("#submit-rq-price").on('click', this.onSubmit.bind(this));

        },

        closeModal: function (){
            $("#modal-content").modal("closeModal");
        },

        openModal: function (){
            $("#modal-content").modal("openModal");
        }

    });
});
