/**
 * Created by Ico on 1/13/2016.
 */

'use strict';

presentoApp.factory('authenticationService', ['$http', '$q', 'baseServiceUrl',
    function ($http, $q, baseServiceUrl) {
        var authenticationApi = baseServiceUrl + '/api/accounts';

        function login(username, password) {
            var deferred = $q.defer();

            $http.post(authenticationApi + '/login', {username: username, password: password})
                .success(function (response) {
                    deferred.resolve(response);
                }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        function register(username, password) {
            var deferred = $q.defer();

            $http.post(authenticationApi + '/register', {username: username, password: password})
                .success(function (response) {
                    deferred.resolve(response);
                }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        return {
            login: login,
            register: register
        };
    }]);

