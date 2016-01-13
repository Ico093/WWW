/**
 * Created by Ico on 1/13/2016.
 */

presentoApp.controller('navigationController', ['$scope', '$location',
    function ($scope, $location) {
        $scope.isAuthenticated = isAuthenticated;
    }]);
