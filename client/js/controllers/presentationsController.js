'use strict';

presentoApp.controller('presentationsController', ['$scope', 'presentationsService', 'notifier',
    function ($scope, presentationsService, notifier) {

        $scope.sortBy = 'title';
        $scope.sortReverse  = false;
        $scope.searchFilter = '';

        presentationsService.getPresentations()
            .then(function (response) {
                $scope.presentations = response;
            }, function (err) {
               notifier.error(err);
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