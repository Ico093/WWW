'use strict';

var presentoApp = angular.module("presentoApp", ['ngRoute', 'ui.bootstrap', 'ui.bootstrap.datepicker', 'ui.bootstrap.timepicker'])
    .value('toastr', toastr)
    .value('isAuthenticated', isAuthenticated)
    .constant('baseServiceUrl', 'http://localhost:8080')

presentoApp.config(function ($routeProvider) {
    $routeProvider
        .when('/register', {
            templateUrl: 'views/register.html',
            controller: 'authenticationController'
        })
        .when('/login', {
            templateUrl: 'views/login.html',
            controller: 'authenticationController'
        })
        .when('/presentations', {
            templateUrl: 'views/presentations.html',
            controller: 'presentationsController'
        })
        .when('/presentation/:id', {
            templateUrl: 'views/presentation-details.html',
            controller: 'presentationDetailsController'
        })
        .when('/presentations/create', {
            templateUrl: 'views/presentations-create.html',
            controller: 'presentationsCreateController'
        })
        .otherwise({
            redirectTo: '/'
        });
});

presentoApp.run(function($rootScope, $location) {
    $rootScope.$on( "$routeChangeStart", function(event, next, current) {
        if (!isAuthenticated()) {
            // no logged user, redirect to /login
            if ( next.templateUrl !== "views/login.html" && next.templateUrl !== "views/register.html" ) {
                $location.path("/login");
            }
        }
    });
});

function isAuthenticated(){
    var token = getCookie("auth_token");
    var expires = getCookie("auth_expires");

    return token !== "" && Date.parse(expires) > Date.now();
}


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