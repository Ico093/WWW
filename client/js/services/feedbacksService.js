'use strict';

presentoApp.factory('feedbacksService', ['$http', '$q', 'baseServiceUrl', 'authenticationService',
    function ($http, $q, baseServiceUrl, authenticationService) {
        var feedbacksApi = baseServiceUrl + '/api/feedbacks';

        var submitFeedback = function (feedback) {
            var formData = getFeedbackFormData(feedback);

            var options = {
                method: 'POST',
                url: feedbacksApi + "/submit",
                data: formData,
                headers: {'Content-Type': undefined}
            };

            return authenticationService.makeAuthenticatedRequest(options, true);
        };

        var getFeedbackFormData = function(feedback){
            var formData = new FormData();
            formData.append('presentationId', feedback.presentationId);
            formData.append('content', feedback.content);

            return formData;
        }

        return {
            submitFeedback: submitFeedback
        };
    }]);