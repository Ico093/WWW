'use strict';

presentoApp.controller('presentationEditController', ['$scope', '$location', '$routeParams', 'presentationsService', 'notifier',
    function ($scope, $location, $routeParams, presentationsService, notifier) {

        $scope.presentationId = $routeParams.id;

        $scope.isCalendarOpened = false;

        presentationsService.getPresentationById($scope.presentationId)
            .then(function (response) {

                $scope.presentation = response;
                $scope.presentation.ondate = new Date($scope.presentation.ondate);
                var fromTimeDigits = $scope.presentation.fromtime.toString().split(".");
                if(fromTimeDigits.length === 1){
                    fromTimeDigits.push("0");
                }

                $scope.fromHours = fromTimeDigits[0];
                $scope.fromMinutes = fromTimeDigits[1];

                if( $scope.fromMinutes.length < 2){
                    $scope.fromMinutes = $scope.fromMinutes + "0";
                }

                var toTimeDigits = $scope.presentation.totime.toString().split(".");
                if(toTimeDigits.length === 1){
                    toTimeDigits.push("0");
                }

                $scope.toHours = toTimeDigits[0];
                $scope.toMinutes = toTimeDigits[1];

                if( $scope.toMinutes.length < 2){
                    $scope.toMinutes = $scope.toMinutes + "0";
                }

            }, function (err) {
                notifier.error(err);
            });

        $scope.cancel = function(){
            $location.path('/presentations');
        };

        $scope.editPresentation = function(formData){
            var fromTime = $scope.fromHours + "." + $scope.fromMinutes;
            formData.fromtime = parseFloat(fromTime);

            var toTime = $scope.toHours + "." + $scope.toMinutes;
            formData.totime = parseFloat(toTime);

            formData.ondate = formData.ondate.toISOString().slice(0, 10);

            presentationsService.updatePresentation($scope.presentationId, formData)
                .then(function (success) {
                        notifier.success("Презентацията е обновена.");
                        $location.path('/presentations');
                    },
                    function (error) {
                        notifier.error(error);
                    }
                );
        };

        $scope.openCalendar = function(){
            $scope.isCalendarOpened = !$scope.isCalendarOpened;
        }
    }])