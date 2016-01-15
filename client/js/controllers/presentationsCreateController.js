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
            var fromTime = $scope.fromHours + "." + $scope.fromMinutes;
            formData.fromtime = parseFloat(fromTime);

            var toTime = $scope.toHours + "." + $scope.toMinutes;
            formData.totime = parseFloat(toTime);

            formData.ondate = formData.ondate.toISOString().slice(0, 10);

            presentationsService.createPresentation(formData)
                .then(function (success) {
                    notifier.success("Презентацията е добавена.");
                    $location.path('/presentations');
                },
                function (error) {
                    notifier.error(error);
                }
            );
        };

        $scope.cancel = function(){
            $location.path('/presentations');
        };

        $scope.openCalendar = function(){
            $scope.isCalendarOpened = !$scope.isCalendarOpened;
        }
    }])