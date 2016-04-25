'use strict';

angular.module('owTracker')
    .controller('OverwatchUserScoreController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            function init() {
                $scope.userScores = [];
                var userId = $rootScope.user.id,
                    period = 30;

                overwatchService.getHigherScores(userId, period).then(function (res) {
                    if (res.status == 200) {
                        $scope.scoresHigh = res.data;
                    }
                });
                overwatchService.getLowerScores(userId, period).then(function (res) {
                    if (res.status == 200) {
                        $scope.scoresLow = res.data;
                    }
                });
                overwatchService.getMyScore(userId, period).then(function (res) {
                    if (res.status == 200) {
                        $scope.myScore = res.data;
                    }
                });
            }

            init();
        }]
    );