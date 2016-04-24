'use strict';

angular.module('owTracker')
    .controller('NewVerdictController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            var newVerdict = {
                map: 'de_dust2',
                overwatchDate: new Date(),
                aimAssist: false,
                visualAssist: false,
                otherAssist: false,
                griefing: false
            };

            function resetVerdictForm() {
                $scope.newVerdict = angular.copy(newVerdict);
            }

            $scope.submitVerdict = function () {
                overwatchService.submitVerdict($scope.newVerdict).then(function (res) {
                    resetVerdictForm();

                    $rootScope.$broadcast('newVerdict', res.data);
                });
            };

            resetVerdictForm();
        }]
    );