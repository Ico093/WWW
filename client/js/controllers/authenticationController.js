/**
 * Created by Ico on 1/13/2016.
 */

presentoApp.controller('authenticationController', ['$scope', '$location', 'authenticationService',
    function ($scope, $location, authenticationService) {
        document.cookie="token=";

        function showPassword() {
            var passwordInput = $('#password');
            var key_attr = passwordInput.attr('type');

            if (key_attr != 'text') {

                $('.checkbox').addClass('show');
                passwordInput.attr('type', 'text');

            } else {

                $('.checkbox').removeClass('show');
                passwordInput.attr('type', 'password');

            }
        }

        function login() {
            var username = $("#username").val();
            var password = $("#password").val();

            authenticationService.login(username, password)
                .then(function (data) {
                    document.cookie="token=" + data.token;

                    $location.url("/presentations")
                }, function (err) {
                    console.log('error: ' + err);
                });
        }

        $scope.showPassword = showPassword;
        $scope.login = login;

    }]);