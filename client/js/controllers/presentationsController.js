'use strict';

presentoApp.controller('presentationsController', ['$scope', '$interval', '$location', 'presentationsService', 'notifier',
    function ($scope, $interval, $location, presentationsService, notifier) {

        $scope.sortBy = 'title';
        $scope.sortReverse  = false;
        $scope.searchFilter = '';

        presentationsService.getPresentations()
            .then(function (response) {
                $scope.presentations = response;
            }, function (err) {
               notifier.error(err);
            });

        $scope.deletePresentation = function(presentation){
            var id = presentation.id;
            presentationsService.deletePresentation(id)
                .then(function (response) {
                    presentationsService.getPresentations()
                        .then(function (presentations) {
                            $scope.presentations = presentations;
                        }, function (err) {
                            notifier.error(err);
                        });
                    notifier.success('Презентацията е изтрита успешно.');
                }, function (err) {
                    notifier.error(err);
                });
        };

    /*  $interval(function () {
          presentationsService.getPresentations()
                .then(function (response) {
                    $scope.presentations = response;
                }, function (err) {
                    notifier.error('Възникна проблем със зареждането на презентациите.');
                });
        }, 5000);*/

    }])