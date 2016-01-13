/**
 * Created by Ico on 1/13/2016.
 */

presentoApp.controller('authenticationController', ['$scope', 'authenticationService',
    function ($scope, authenticationService) {

        function showPassword() {

            var key_attr = $('#password').attr('type');

            if (key_attr != 'text') {

                $('.checkbox').addClass('show');
                $('#password').attr('type', 'text');

            } else {

                $('.checkbox').removeClass('show');
                $('#password').attr('type', 'password');

            }
        };

        function login() {
            var username = $("#username").val();
            var password = $("#password").val();

            authenticationService.login(username, password)
                .then(function (response) {

                    console.log(response);
                }, function (err) {
                    console.log('error: ' + err);
                });
        };

        $scope.showPassword = showPassword;
        $scope.login = login;

    }]);