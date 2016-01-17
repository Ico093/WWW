'use strict';

presentoApp.factory('feedbacksService', ['$http', '$q', 'baseServiceUrl', 'authenticationService',
    function ($http, $q, baseServiceUrl, authenticationService) {
        var feedbacksApi = baseServiceUrl + '/api/feedbacks';

        var submitFeedback = function (feedback) {
            var options = {
                method: 'POST',
                url: feedbacksApi + "/submit",
                data: feedback,
            };

            return authenticationService.makeAuthenticatedRequest(options);
        };

        return {
            submitFeedback: submitFeedback
        };
    }]);