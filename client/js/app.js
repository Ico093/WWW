'use strict';

var presentoApp = angular.module("presentoApp", ['ngRoute'])
    .value('toastr', toastr)
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

presentoApp.run(function($rootScope, $location) {
    $rootScope.$on( "$routeChangeStart", function(event, next, current) {
        var token = getCookie("auth_token");
        var expires = getCookie("auth_expires");

        if (token === "" || Date.parse(expires) < Date.now()) {
            // no logged user, redirect to /login
            if ( next.templateUrl !== "views/login.html" || next.templateUrl !== "views/register.html" ) {
                $location.path("/login");
            }
        }
    });
});

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