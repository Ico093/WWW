presentoApp.directive('enterKey', function () {
    return {
        restrict: 'A',
        scope: {
            feedback: '=',
            callback: '&',
        },
        link: function (scope, elem, attrs) {

            elem.bind('keydown', function (event) {
                var code = event.keyCode || event.which;

                if (code === 13) {
                    if (!event.shiftKey) {
                        event.preventDefault();
                        scope.$apply(attrs.enterKey);
                        scope.callback();
                    }
                }
            });
        }
    }
});