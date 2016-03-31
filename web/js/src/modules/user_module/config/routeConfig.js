'use strict';

var app = angular.module('owTracker');

app.constant('STATE_LOGIN', 'login');
app.constant('STATE_REGISTER', 'register');

app.config(['$stateProvider', 'STATE_LOGIN', 'STATE_REGISTER', function ($stateProvider, STATE_LOGIN, STATE_REGISTER) {
    $stateProvider.state(STATE_LOGIN, {
        parent: 'page',
        data: {requireLogin: false},
        controller: 'UserController',
        templateUrl: 'js/src/modules/user_module/views/login.html',
        url: '/login'
    }).state(STATE_REGISTER, {
        parent: 'page',
        data: {requireLogin: false},
        controller: 'UserController',
        templateUrl: 'js/src/modules/user_module/views/register.html',
        url: '/register'
    });
}]);