/**
 * Created by Ico on 1/13/2016.
 */

'use strict';

presentoApp.factory('authenticationService', ['$http', '$location', '$q', 'baseServiceUrl',
    function ($http, $location, $q, baseServiceUrl) {
        var authenticationApi = baseServiceUrl + '/api/accounts';

        function login(username, password) {
            var deferred = $q.defer();

            $http.post(authenticationApi + '/login', {username: username, password: password})
                .success(function (response) {
                    deferred.resolve(response.data);
                }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        function register(username, password) {
            var deferred = $q.defer();

            $http.post(authenticationApi + '/register', {username: username, password: password})
                .success(function (response) {
                    deferred.resolve(response.data);
                }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        function logout() {
            var token = getCookie("auth_token");

            $http.post(authenticationApi + '/logout', {token: token});

            document.cookie = 'auth_token=;';
            document.cookie = 'auth_expires=;';
        }

        function makeAuthenticatedRequest(options, isFormData) {
            if (isAuthenticated()) {
                var token = getCookie("auth_token");

                if (options.method == "GET") {
                    options.params = options.params || {};
                    options.params.token = token;
                }
                else {
                    options.data = options.data || {};

                    if (isFormData === true) {
                        options.data.append("token", token);
                    } else {
                        options.data.token = token;
                    }
                }
            } else {
                $location.url("/login");
            }

            var deferred = $q.defer();

            $http(options)
                .success(function (response) {
                    extendExpiry(response.expires)
                    deferred.resolve(response.data);
                })
                .error(function (err) {
                    deferred.reject(err);
                });

            return deferred.promise;
        }

        function extendExpiry(date) {
            document.cookie = 'auth_expires=' + date;
        }

        function isAuthenticated() {
            var token = getCookie("auth_token");
            var expires = getCookie("auth_expires");

            return token !== "" && Date.parse(expires) > Date.now();
        }

        function getUsername() {
            var token = getCookie("auth_token");

            var deferred = $q.defer();

            $http.get(authenticationApi + '/getUsername/' + token)
                .success(function (response) {
                    deferred.resolve(response.data);
                })
                .error(function (err, status) {
                    deferred.reject(err);
                });

            return deferred.promise;
        }

        function getCookie(c_name) {
            var i, x, y, ARRcookies = document.cookie.split(";");

            for (i = 0; i < ARRcookies.length; i++) {
                x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                x = x.replace(/^\s+|\s+$/g, "");
                if (x == c_name) {
                    return unescape(y);
                }
            }
        }

        return {
            login: login,
            register: register,
            logout: logout,
            makeAuthenticatedRequest: makeAuthenticatedRequest,
            getCookie: getCookie,
            getUsername: getUsername
        };
    }
]);