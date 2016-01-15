'use strict';

presentoApp.controller('presentationDetailsController', ['$scope', '$routeParams', 'presentationsService', 'notifier',
    function ($scope, $routeParams, presentationsService, notifier) {

        $scope.presentationId = $routeParams.id;

        presentationsService.getPresentationById($scope.presentationId)
            .then(function (response) {
                $scope.presentation = response;
            }, function (err) {
                notifier.error(err);
            });
    }])