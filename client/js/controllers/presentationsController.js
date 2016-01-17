'use strict';

presentoApp.controller('presentationsController', ['$scope', '$interval', '$location', 'presentationsService', 'notifier',
    function ($scope, $interval, $location, presentationsService, notifier) {

        $scope.sortBy = 'title';
        $scope.sortReverse = false;
        $scope.searchFilter = '';

        presentationsService.getPresentations()
            .then(function (response) {
                $scope.presentations = response;
            }, function (err) {
                notifier.error(err);
            });

        $scope.deletePresentation = function (id) {

            if (confirm("Сигурни ли сте, че искате да изтриете презентацията?")) {
                presentationsService.deletePresentation(id)
                    .then(function (response) {
                        var index = getIndexOfPresentation(id);
                        if (index !== -1) {
                            $scope.presentations.splice(index, 1);
                        }

                        notifier.success('Презентацията е изтрита успешно.');
                    }, function (err) {
                        notifier.error(err);
                    });
            }
        };

        var getIndexOfPresentation = function (id) {
            var index = -1;
            for (var i = 0; i < $scope.presentations.length; i++) {
                if ($scope.presentations[i].id === id) {
                    index = i;
                }
            }

            return index;
        }


        /*  $interval(function () {
         presentationsService.getPresentations()
         .then(function (response) {
         $scope.presentations = response;
         }, function (err) {
         notifier.error('Възникна проблем със зареждането на презентациите.');
         });
         }, 5000);*/

    }])