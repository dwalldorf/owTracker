'use strict';

var app = angular.module('owTracker');

app.constant('STATE_INDEX', 'index');
app.constant('STATE_USER_SCORES', 'scores');

app.config(['$stateProvider', 'STATE_INDEX', 'STATE_USER_SCORES', function ($stateProvider, STATE_INDEX, STATE_USER_SCORES) {
    $stateProvider.state(STATE_INDEX, {
            parent: 'loggedIn',
            data: {requireLogin: true},
            templateUrl: 'js/src/modules/overwatch_module/views/index.html',
            url: '/'
        },
        $stateProvider.state(STATE_USER_SCORES, {
            parent: 'loggedIn',
            data: {requireLogin: true},
            controller: 'OverwatchUserScoreController',
            templateUrl: 'js/src/modules/overwatch_module/views/scores.html',
            url: '/scores'
        }));
}]);