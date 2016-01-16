'use strict';

presentoApp.factory('presentationsService', ['$http', '$q', 'baseServiceUrl', 'authenticationService',
    function ($http, $q, baseServiceUrl, authenticationService) {
        var presentationsApi = baseServiceUrl + '/api/presentations';

        var getPresentationFormData = function (presentation) {
            var formData = new FormData();
            formData.append('title', presentation.title);
            formData.append('description', presentation.description);
            formData.append('ondate', presentation.ondate);
            formData.append('fromtime', presentation.fromtime);
            formData.append('totime', presentation.totime);
            formData.append('presentationFile', presentation.file);

            return formData;
        };

        var getPresentations = function () {
            var options = {
                method: 'GET',
                url: presentationsApi + '/get'
            };

            return authenticationService.makeAuthenticatedRequest(options);
        }

        var getPresentationById = function (id) {
            var options = {
                method: 'GET',
                url: presentationsApi + "/getById/" + id
            };

            return authenticationService.makeAuthenticatedRequest(options);
        }

        var createPresentation = function (newPresentation) {
            var deferred = $q.defer();
            var formData = getPresentationFormData(newPresentation);

            $http.post(presentationsApi + "/create", formData, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                })
                .success(function (response) {
                    deferred.resolve(response);
                })
                .error(function (error) {
                    deferred.reject(error);
                });

            return deferred.promise;
        };

        return {
            getPresentations: getPresentations,
            getPresentationById: getPresentationById,
            createPresentation: createPresentation
        };
    }]);