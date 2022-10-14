define([
    'Magento_Ui/js/grid/listing'
], function (Collection) {
    'use strict';

    return Collection.extend({
        defaults: {
            template: 'AnkitDev_RequestInvoice/ui/grid/listing'
        },
        getRowClass: function (row) {

            if(row.status == 'approve') {
                return 'approved';
            } else {
                return 'disapproved';
            }
        }
    });
});