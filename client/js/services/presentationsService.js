'use strict';

presentoApp.factory('presentationsService', ['$http', '$q', 'baseServiceUrl',
    function ($http, $q, baseServiceUrl) {
        var presentationsApi = baseServiceUrl + '/api/presentations';

        var getPresentations = function() {
            var deferred = $q.defer();

            $http.get(presentationsApi + '/get')
                .success(function (response) {
                    deferred.resolve(response);
                }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        return {
            getPresentations: getPresentations
        };
    }]);
