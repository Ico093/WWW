/**
 * Created by Ico on 1/10/2016.
 */
'use strict';

var presentoApp = angular.module("presentoApp", ['ngResource', 'ngRoute'])

presentoApp.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/presentations', {
            templateUrl: 'views/presentations.html',
            controller: 'presentationsController'
        })
        .otherwise({
            redirectTo: '/'
        });
});