'use strict';

angular.module('owTracker')
    .controller('OverwatchController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            function init() {
                $scope.overwatches = [];
                overwatchService.getOverwatchList().then(function (res) {
                    if (res.status == 200) {
                        $scope.overwatches = res.data;
                    }
                });
            }

            $rootScope.$on('newOverwatch', function (event, overwatch) {
                $scope.overwatches.push(overwatch);
            });

            init();
        }]
    );