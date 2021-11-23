define(['jquery'], function ($) {
    'use strict';
    let listeners = {}

    let fields = ['shippingAddress.company']

    function reloadFields (e) {
        let cb = e.detail.cb || function () {}
        for(let listen in listeners) {
            cb({[listen]: listeners[listen]})
            listeners[listen]()
        }

    }
    document.addEventListener('updateShippingValidationRules', reloadFields)


    let mixin = {
        updateShippingValidationRules: function () {
            this.initObservable()
        },

        initObservable: function () {
            let rules = this.validation = this.validation || {};

            if(fields.indexOf(this.dataScope) + 1) {
                listeners[this.dataScope] = this.initObservable.bind(this)
            }

            this._super();

            this.observe('error disabled focused preview visible value warn notice isDifferedFromDefault')
                .observe('isUseDefault serviceDisabled')
                .observe({
                    'required': !!rules['required-entry']
                });

            return this;
        },

    };

    return function (target) {
        return target.extend(mixin);
    };
});
