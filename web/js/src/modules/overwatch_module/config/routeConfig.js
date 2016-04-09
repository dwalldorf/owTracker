'use strict';

var app = angular.module('owTracker');

app.constant('STATE_INDEX', 'index');

app.config(['$stateProvider', 'STATE_INDEX', function ($stateProvider, STATE_INDEX) {
    $stateProvider.state(STATE_INDEX, {
        parent: 'page',
        data: {requireLogin: true},
        controller: 'OverwatchController',
        templateUrl: 'js/src/modules/overwatch_module/views/default.html',
        url: '/'
    });
}]);