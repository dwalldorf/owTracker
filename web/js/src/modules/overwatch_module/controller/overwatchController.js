'use strict';

angular.module('owTracker')
    .controller('OverwatchController', ['$rootScope', '$scope', 'OverwatchService',
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

            function getTodayDate() {
                var today = new Date();
                var day = today.getDate();
                var month = today.getMonth() + 1; //January is 0!

                var year = today.getFullYear();
                if (day < 10) {
                    day = '0' + day
                }
                if (month < 10) {
                    month = '0' + month
                }
                today = month + '/' + day + '/' + year;

                return today;
            }

            init();
        }]
    );