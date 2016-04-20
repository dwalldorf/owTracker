'use strict';

angular.module('owTracker')
    .controller('OverwatchController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            function init() {
                $scope.overwatches = [];
                $scope.currentPage = 0;
                $scope.itemsPerPage = 25;

                overwatchService.getOverwatchList().then(function (res) {
                    if (res.status == 200) {
                        $scope.overwatches = res.data;
                    }
                });
            }

            $scope.numberOfPages = function () {
                return Math.ceil($scope.overwatches.length / $scope.itemsPerPage)
            };

            $rootScope.$on('newOverwatch', function (event, overwatch) {
                $scope.overwatches.push(overwatch);
            });

            init();
        }]
    )

    .filter('startFrom', function () {
        return function (input, start) {
            start = +start; //parse to int
            return input.slice(start);
        }
    });