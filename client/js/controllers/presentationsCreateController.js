'use strict';

presentoApp.controller('presentationsCreateController', ['$scope','$location', 'presentationsService', 'notifier',
    function ($scope, $location, presentationsService, notifier) {

        $scope.datepickerOptions =
        {
            format: 'yyyy-mm-dd',
            language: 'bg',
            autoclose: true,
            weekStart: 0,
        };

        $scope.isCalendarOpened = false;

        $scope.fromTime = new Date();
        $scope.fromHours = $scope.fromTime.getHours();
        $scope.fromMinutes = $scope.fromTime.getMinutes();
        if($scope.fromMinutes < 10){
            $scope.fromMinutes = "0" + $scope.fromMinutes;
        }

        $scope.toTime = new Date();
        $scope.toHours = $scope.toTime.getHours();
        $scope.toMinutes = $scope.toTime.getMinutes();
        if($scope.toMinutes < 10){
            $scope.toMinutes = "0" + $scope.toMinutes;
        }

        $scope.submitPresentation = function (formData) {

            presentationsService.createPresentation(formData)
                .then(function (success) {
                    notifier.success("Презентацията е добавена.");
                    $location.path('#/presentations');
                },
                function (error) {
                    notifier.error(error.message);
                }
            );
        };

        $scope.openCalendar = function(){
            $scope.isCalendarOpened = !$scope.isCalendarOpened;
        }
    }])