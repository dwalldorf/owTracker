'use strict';

angular.module('owTracker')
    .controller('OverwatchUserScoreController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            var initialScoreboard = {
                higher: [],
                lower: [],
                self: []
            };

            function init() {
                $scope.period = '30';
                $scope.periods = [
                    {
                        p: '30',
                        name: 'monthly'
                    },
                    {
                        p: '7',
                        name: 'weekly'
                    },
                    {
                        p: '1',
                        name: 'daily'

                    },
                    {
                        p: '0',
                        name: 'all time'
                    }
                ];

                getScoreboard($scope.period);
            }

            function getScoreboard(period) {
                resetScoreboard();
                var userId = $rootScope.user.id;

                overwatchService.getHigherScores(userId, period).then(function (res) {
                    if (res.status == 200) {
                        $scope.scoreboard.higher = res.data;
                    }
                });
                overwatchService.getLowerScores(userId, period).then(function (res) {
                    if (res.status == 200) {
                        $scope.scoreboard.lower = res.data;
                    }
                });
                overwatchService.getMyScore(userId, period).then(function (res) {
                    if (res.status == 200) {
                        $scope.scoreboard.self = res.data;
                    }
                });
            }

            function resetScoreboard() {
                $scope.scoreboard = angular.copy(initialScoreboard);
            }


            // scope functions
            $scope.restFinished = function () {
                return (
                    $scope.scoreboard.higher.scores !== [] &&
                    $scope.scoreboard.lower.scores !== [] &&
                    $scope.scoreboard.self.score !== undefined
                );
            };

            $scope.updatePeriod = function () {
                getScoreboard($scope.period);
            };


            // execution
            init();
        }]
    );