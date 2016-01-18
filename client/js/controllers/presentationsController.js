'use strict';

presentoApp.controller('presentationsController', ['$scope', '$interval', '$location', 'presentationsService', 'notifier',
    function ($scope, $interval, $location, presentationsService, notifier) {

        $scope.sortBy = 'title';
        $scope.sortReverse = false;
        $scope.searchFilter = '';
        $scope.currentPage = 1;
        $scope.numPerPage = 10;
        $scope.maxSize = 5;
        $scope.isLoaded = false;

        presentationsService.getPresentations()
            .then(function (response) {
                $scope.presentations = response;

                $scope.$watch('currentPage + numPerPage', function () {
                    var begin = (($scope.currentPage - 1) * $scope.numPerPage)
                        , end = begin + $scope.numPerPage;

                    $scope.filteredPresentations = $scope.presentations.slice(begin, end);
                });

                $scope.isLoaded = true;
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

    }])