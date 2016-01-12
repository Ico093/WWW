'use strict';

presentoApp.controller('presentationsController', ['$scope', 'presentationsService',
    function ($scope, presentationsService) {

        presentationsService.getPresentations()
            .then(function (response) {
                $scope.presentations = response;
                console.log(response);
            }, function (err) {
               console.log('error: ' + err);
            });

      /*  $interval(function () {
            MessagesService.getFilteredMessages($scope.filters)
                .then(function (response) {
                    $scope.messages = response;
                }, function (err) {
                    notifier.error('Messages could not be loaded.');
                });
        }, 30 * 1000);*/

    }])