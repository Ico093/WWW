/**
 * Created by Ico on 1/13/2016.
 */

presentoApp.controller('navigationController', ['$scope', '$location', 'authenticationService',
    function ($scope, $location, authenticationService) {
        function logout() {
            authenticationService.logout();
            $location.url("/login");
        }

        $scope.logout = logout;
        $scope.isAuthenticated = isAuthenticated;
    }]);
