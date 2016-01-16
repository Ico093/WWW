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

        $scope.getPresentationById = function(id){
            presentationsService.getPresentationById(id)
                .then(function (response) {
                    $scope.presentation = respons;
                }, function (err) {
                    notifier.error(err);
                });
        }

        $scope.test = function(){
            alert('test');
        }

      /*  $interval(function () {
            MessagesService.getFilteredMessages($scope.filters)
                .then(function (response) {
                    $scope.messages = response;
                }, function (err) {
                    notifier.error('Messages could not be loaded.');
                });
        }, 30 * 1000);*/

    }])