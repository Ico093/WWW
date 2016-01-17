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

        $scope.submitFeedback = function (feedbackContent) {
           /* if ($scope.feedback !== '') {*/

                var feedback = {
                    username: $scope.presentation.username,
                    presentationId: $scope.presentationId,
                    content: feedbackContent
                }

                feedbacksService.submitFeedback(feedback)
                    .then(function (response) {
                        notifier.success('Коментарът беше добавен успешно.')
                    }, function (err) {
                        notifier.error(err);
                    });
           /* }*/
        };

    }])