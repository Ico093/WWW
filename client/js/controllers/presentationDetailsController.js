'use strict';

presentoApp.controller('presentationDetailsController', ['$scope', '$routeParams', 'presentationsService',
    'feedbacksService', 'authenticationService', 'notifier',
    function ($scope, $routeParams, presentationsService, feedbacksService, authenticationService, notifier) {

        $scope.presentationId = $routeParams.id;
        $scope.feedback = '';

        presentationsService.getPresentationById($scope.presentationId)
            .then(function (response) {
                $scope.presentation = response;
            }, function (err) {
                notifier.error(err);
            });

        $scope.submitFeedback = function (feedback, presentationId) {
            if (feedback !== '') {

                var feedbackObject = {
                    presentationId: presentationId,
                    content: feedback
                };

                $("#presentationFeedbackTB").val('');

                feedbacksService.submitFeedback(feedbackObject)
                    .then(function (response) {
                        notifier.success('Коментарът беше добавен успешно.');
                        authenticationService.getUsername()
                            .then(function (response) {
                                var username = response;
                                var feedback = {content: feedbackObject.content, username: username};
                                $scope.presentation.feedbacks.push(feedback);
                            }, function (err) {
                                notifier.error(err);
                            });
                    }, function (err) {
                        notifier.error(err);
                    });
            }
        };

        $scope.downloadPresentation = function (id) {
            presentationsService.downloadPresentation(id)
                .then(function (response) {
                }, function (err) {
                    notifier.info(err.errorMessage);
                });
        };
    }])