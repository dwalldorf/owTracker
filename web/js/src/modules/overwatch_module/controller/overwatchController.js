'use strict';

angular.module('owTracker')
    .controller('OverwatchController', ['$rootScope', '$scope', 'OverwatchService', function ($rootScope, $scope, overwatchService) {

        var newOverwatch = {
            map: {id: 0},
            aimAssist: false,
            visualAssist: false,
            otherAssist: false,
            griefing: false
        };

        function resetOverwatchForm() {
            $scope.newOverwatch = angular.copy(newOverwatch);
        }

        function init() {
            resetOverwatchForm();

            $scope.overwatches = [];
            overwatchService.getOverwatchList().then(function (res) {
                if (res.status == 200) {
                    $scope.overwatches = res.data;
                }
            });
        }

        $scope.submitOverwatch = function () {
            overwatchService.submitOverwatch($scope.newOverwatch).then(function (res) {
                resetOverwatchForm();
                $scope.overwatches.push(res.data);
            });
        };

        init();
    }]);