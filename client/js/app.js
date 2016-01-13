'use strict';

var presentoApp = angular.module("presentoApp", ['ngRoute'])
                         .constant('baseServiceUrl', 'http://localhost:8080')

presentoApp.config(function ($routeProvider) {
    $routeProvider
        .when('/login', {
            templateUrl: 'views/login.html',
            controller: 'authenticationController'
        })
        .when('/presentations', {
            templateUrl: 'views/presentations.html',
            controller: 'presentationsController'
        })
        .otherwise({
            redirectTo: '/'
        });
});