'use strict';

angular.module('owTracker')
    .controller('NewOverwatchController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            var newOverwatch = {
                map: {id: 0},
                overwatchDate: new Date(),
                aimAssist: false,
                visualAssist: false,
                otherAssist: false,
                griefing: false
            };

            function resetOverwatchForm() {
                $scope.newOverwatch = angular.copy(newOverwatch);
            }

            $scope.submitOverwatch = function () {
                overwatchService.submitOverwatch($scope.newOverwatch).then(function (res) {
                    resetOverwatchForm();

                    $rootScope.$broadcast('newOverwatch', res.data);
                });
            };

            resetOverwatchForm();
        }]
    );