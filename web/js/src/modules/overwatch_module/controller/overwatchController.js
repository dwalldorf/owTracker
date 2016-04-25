'use strict';

angular.module('owTracker')
    .controller('OverwatchController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            function init() {
                $scope.restFinished = false;
                $scope.verdicts = [];
                $scope.currentPage = 0;
                $scope.itemsPerPage = 25;

                overwatchService.getVerdicts().then(function (res) {
                    if (res.status == 200) {
                        $scope.restFinished = true;
                        $scope.verdicts = res.data;
                    }
                });
            }

            $scope.numberOfPages = function () {
                return Math.ceil($scope.verdicts.length / $scope.itemsPerPage)
            };

            $rootScope.$on('newVerdict', function (event, verdict) {
                $scope.verdicts.push(verdict);
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