'use strict';

angular.module('owTracker')
    .controller('OverwatchUserScoreController', ['$rootScope', '$scope', 'OverwatchService',
        function ($rootScope, $scope, overwatchService) {

            function init() {
                $scope.userScores = [];
                overwatchService.getScoreboard().then(function (res) {
                    if (res.status == 200) {
                        $scope.userScores = res.data;
                    }
                });
            }

            init();
        }]
    );