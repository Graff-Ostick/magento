require([],{});
/*
require(

    [
        'jquery',
        'Magento_Ui/js/modal/modal',
    ],
    function(
        $,
        modal
    ) {
        let url = "<?php echo $block->getUrl('request_price/index/save') ?>";
        let sku = "<?php echo $block->getProduct()->getSku() ?>";
        let created = "<?php echo $block->getDate(); ?>";

        let options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Request the price',
            buttons: [{
                text: $.mage.__('Close'),
                class: 'modal-close',
                click: this.closeModal,
            },
                {
                    text: $.mage.__('Submit'),
                    class: 'modal-close',
                    click: onsubmit
                }
            ]
        };

        function onsubmit(){
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    name:$("#rp-name").val(),
                    email:$("#rp-email").val(),
                    comment:$("#rp-comment").val(),
                    sku:sku,
                    created_at:created,
                    status: 'New'
                },
                showLoader: true,
            });
        }


        modal(options, $('#modal-content'));
        $("#price-request-btn").on('click',function(){
            $("#modal-content").modal("openModal");

        });
    }
);

*/
