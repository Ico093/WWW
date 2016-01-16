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

            if (presentation.file) {
                formData.append('presentationFile', presentation.file);
            }

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
            var formData = getPresentationFormData(newPresentation);

            var options = {
                method: 'POST',
                url: presentationsApi + "/create",
                data: formData,
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            };

            return authenticationService.makeAuthenticatedRequest(options);
        };

        var updatePresentation = function (id, presentation) {

            var formData = getPresentationFormData(presentation);

            var options = {
                method: 'POST',
                url: presentationsApi + "/update/" + id,
                data: formData,
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            };

            return authenticationService.makeAuthenticatedRequest(options);
        };

        return {
            getPresentations: getPresentations,
            getPresentationById: getPresentationById,
            createPresentation: createPresentation,
            updatePresentation: updatePresentation
        };
    }]);