'use strict';

angular.module('owTracker')
    .controller('OverwatchController', ['$scope', 'OverwatchService', function ($scope, overwatchService) {

        function init() {
            $scope.newOverwatch = {
                map: 'de_dust2',
                aim: false,
                visual: false,
                other: false,
                griefing: false
            };

            overwatchService.getOverwatchList().then(function (res) {
                $scope.overwatches = res.data;
                console.log(res);


            });
        }

        $scope.submitOverwatch = function () {
            overwatchService.submitOverwatch($scope.newOverwatch);
        };


        init();
    }]);