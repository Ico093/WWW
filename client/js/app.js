'use strict';

var presentoApp = angular.module("presentoApp", ['ngRoute'])
                         .constant('baseServiceUrl', 'http://localhost:8080')

presentoApp.config(function ($routeProvider) {
    $routeProvider
        .when('/presentations', {
            templateUrl: 'views/presentations.html',
            controller: 'presentationsController'
        })
        .otherwise({
            redirectTo: '/'
        });
});