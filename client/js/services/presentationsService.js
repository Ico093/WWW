'use strict';

presentoApp.factory('presentationsService', ['$http', '$q', 'baseServiceUrl',
    function ($http, $q, baseServiceUrl) {
        var presentationsApi = baseServiceUrl + '/api/presentations';

        var getPresentationFormData = function (presentation) {
            var formData = new FormData();
            formData.append('title', presentation.title);
            formData.append('description', presentation.description);
            formData.append('date', presentation.date);
            formData.append('from', presentation.from);
            formData.append('to', presentation.to);
            //formData.append('image', presentation.username);

            return formData;
        };

        var getPresentations = function() {
            var deferred = $q.defer();

            $http.get(presentationsApi + '/get')
                .success(function (response) {
                    deferred.resolve(response);
                }).error(function (err) {
                deferred.reject(err);
            });

            return deferred.promise;
        }

        var getPresentationById = function (id) {
            var deferred = $q.defer();

            $http.get(presentationsApi + "/getById/" + id)
                .success(function(response){
                    deferred.resolve(response);
                }).error(function(err){
                deferred.reject(err);
            });

            return deferred.promise;
        }

        var createPresentation = function (newPresentation) {
            var deferred = $q.defer();
            var formData = getPresentationFormData(newPresentation);

            $http.post(presentationsApi  + "/create", formData, {
                    headers: { 'Content-Type': undefined }
                }
                )
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