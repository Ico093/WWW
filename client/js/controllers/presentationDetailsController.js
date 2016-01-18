'use strict';

presentoApp.controller('presentationDetailsController', ['$scope', '$routeParams', 'presentationsService', 'feedbacksService', 'notifier',
    function ($scope, $routeParams, presentationsService, feedbacksService, notifier) {

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
                }

                feedbacksService.submitFeedback(feedbackObject)
                    .then(function (response) {
                        notifier.success('Коментарът беше добавен успешно.');
                        presentationsService.getPresentationById($scope.presentationId)
                            .then(function (response) {
                                $scope.presentation = response;
                            }, function (err) {
                                notifier.error(err);
                            });
                    }, function (err) {
                        notifier.error(err);
                    });
            }
        };

        function downloadPresentation(id) {
            presentationsService.downloadPresentation(id);
        };

        $scope.downloadPresentation = downloadPresentation;
    }])