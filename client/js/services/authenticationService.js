/**
 * Created by Ico on 1/13/2016.
 */

'use strict';

presentoApp.factory('authenticationService', ['$http', '$q', 'baseServiceUrl',
    function ($http, $q, baseServiceUrl) {
        var authenticationApi = baseServiceUrl + '/api/accounts';

        var login = function (username, password) {
            var deferred = $q.defer();

            $http.post(authenticationApi + '/login', {username: username, password: password})
                .success(function (response) {
                    deferred.resolve(response);
                }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        return {
            login: login
        };
    }]);
