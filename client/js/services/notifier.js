/**
 * Created by Ico on 1/13/2016.
 */

'use strict';

presentoApp.factory('notifier', ['toastr', function (toastr) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "500",
        "timeOut": "3000",
        "extendedTimeOut": "500",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    return {
        success: function (msg) {
            toastr.success(msg);
        },
        error: function (msg) {
            toastr.error(msg);
        },
        info: function (msg) {
            toastr.info(msg);
        },
        warning: function (msg) {
            toastr.warning(msg);
        }
    }
}]);