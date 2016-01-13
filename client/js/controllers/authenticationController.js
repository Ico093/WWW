/**
 * Created by Ico on 1/13/2016.
 */

presentoApp.controller('authenticationController', ['$scope', '$location', 'authenticationService', 'notifier',
    function ($scope, $location, authenticationService, notifier) {
        document.cookie = "auth_token=";
        document.cookie = "auth_expires=";

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
                    document.cookie = 'auth_token=' + data.token;
                    document.cookie = 'auth_expires=' + data.expires;

                    notifier.success(data.message)

                    $location.url("/presentations")
                }, function (error) {
                    notifier.error(error.errorMessage)
                });
        }

        function register() {
            var username = $("#username").val();
            var password = $("#password").val();

            authenticationService.register(username, password)
                .then(function (data) {
                    notifier.success(data.message)

                    $location.url("/login")
                }, function (error) {
                    notifier.error(error.errorMessage)
                });
        }

        $scope.showPassword = showPassword;
        $scope.login = login;
        $scope.register = register;

    }]);