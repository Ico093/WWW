/**
 * Created by Ico on 1/13/2016.
 */

presentoApp.controller('navigationController', ['$scope', '$location', 'authenticationService',
    function ($scope, $location, authenticationService) {
        function logout() {
            authenticationService.logout();
        }

        $scope.isAuthenticated = isAuthenticated;
    }]);
